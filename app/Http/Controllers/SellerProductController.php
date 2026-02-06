<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    public function index()
    {
        $query = Product::with('category')
            ->where('user_id', Auth::id());

        if (request('search')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('sku', 'like', '%' . request('search') . '%');
            });
        }

        if (request('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('low_stock')) {
            $query->where('stock_quantity', '<=', 5);
        }

        if (request('price_min') !== null && request('price_min') !== '') {
            $query->where('price', '>=', request('price_min'));
        }

        if (request('price_max') !== null && request('price_max') !== '') {
            $query->where('price', '<=', request('price_max'));
        }

        if (request('created_from')) {
            $query->whereDate('created_at', '>=', request('created_from'));
        }

        if (request('created_to')) {
            $query->whereDate('created_at', '<=', request('created_to'));
        }

        $products = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $lowStockCount = Product::where('user_id', Auth::id())
            ->where('stock_quantity', '<=', 5)
            ->count();

        return view('seller.stock', compact('products', 'categories', 'lowStockCount'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0', 'gte:price'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'category_id' => ['required', 'exists:categories,id'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'string'],
            'images_upload' => ['nullable', 'array'],
            'images_upload.*' => ['file', 'image', 'max:2048', 'dimensions:min_width=200,min_height=200'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        if ($validated['status'] === Product::STATUS_ARCHIVED) {
            $validated['is_active'] = false;
        }
        $validated['slug'] = $this->generateUniqueSlug($validated['name']);
        $validated['published_at'] = $validated['status'] === Product::STATUS_PUBLISHED ? now() : null;
        $validated['images'] = $this->mergeImages(
            $this->parseImages($validated['images'] ?? null),
            $this->storeUploadedImages($request)
        );

        $product = Product::create($validated);

        if ($product->stock_quantity > 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'delta' => $product->stock_quantity,
                'reason' => 'initial_stock',
            ]);
        }

        return redirect()->route('seller.stock')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::orderBy('name')->get();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0', 'gte:price'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'category_id' => ['required', 'exists:categories,id'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'string'],
            'images_upload' => ['nullable', 'array'],
            'images_upload.*' => ['file', 'image', 'max:2048', 'dimensions:min_width=200,min_height=200'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        if ($validated['status'] === Product::STATUS_ARCHIVED) {
            $validated['is_active'] = false;
        }
        if ($product->name !== $validated['name']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], $product->id);
        }
        if ($validated['status'] === Product::STATUS_PUBLISHED && !$product->published_at) {
            $validated['published_at'] = now();
        }
        if ($validated['status'] !== Product::STATUS_PUBLISHED) {
            $validated['published_at'] = null;
        }
        $textImages = $this->parseImages($validated['images'] ?? null);
        $uploadedImages = $this->storeUploadedImages($request);
        if ($textImages === null && empty($uploadedImages)) {
            $validated['images'] = $product->images;
        } else {
            $validated['images'] = $this->mergeImages($textImages, $uploadedImages);
        }

        $oldStock = $product->stock_quantity;
        $product->update($validated);

        $delta = $product->stock_quantity - $oldStock;
        if ($delta !== 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'delta' => $delta,
                'reason' => 'manual_edit',
            ]);
        }

        return redirect()->route('seller.stock')->with('success', 'Product updated successfully.');
    }

    public function adjustStock(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'delta' => ['required', 'integer', 'not_in:0'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::transaction(function () use ($product, $validated) {
                $locked = Product::whereKey($product->id)->lockForUpdate()->first();

                $newStock = $locked->stock_quantity + $validated['delta'];
                if ($newStock < 0) {
                    throw new \RuntimeException('Stock insuffisant.');
                }

                $locked->update(['stock_quantity' => $newStock]);

                StockMovement::create([
                    'product_id' => $locked->id,
                    'user_id' => Auth::id(),
                    'delta' => $validated['delta'],
                    'reason' => $validated['reason'] ?: 'manual_adjustment',
                ]);
            });
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Stock mis à jour.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $hasActiveOrders = $product->orderItems()
            ->whereHas('order', function ($query) {
                $query->whereIn('status', ['pending', 'processing', 'shipped']);
            })
            ->exists();

        if ($hasActiveOrders) {
            return redirect()->back()->with('error', 'Impossible de supprimer un produit lié à des commandes en cours.');
        }

        $product->delete();

        return redirect()->route('seller.stock')->with('success', 'Product deleted successfully.');
    }

    private function parseImages(?string $images): ?array
    {
        if (!$images) {
            return null;
        }

        $list = array_values(array_filter(array_map('trim', explode(',', $images))));

        return $list ?: null;
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base ?: Str::random(8);
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function storeUploadedImages(Request $request): array
    {
        $files = $request->file('images_upload', []);
        if (!$files) {
            return [];
        }

        $paths = [];
        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }
            $stored = $file->store('products', 'public');
            $paths[] = Storage::disk('public')->url($stored);
        }

        return $paths;
    }

    private function mergeImages(?array $textImages, array $uploadedImages): ?array
    {
        $merged = array_values(array_unique(array_filter(array_merge(
            $textImages ?? [],
            $uploadedImages
        ))));

        return $merged ?: null;
    }
}
