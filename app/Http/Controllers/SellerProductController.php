<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

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
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'category_id' => ['required', 'exists:categories,id'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['images'] = $this->parseImages($validated['images'] ?? null);

        Product::create($validated);

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
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'category_id' => ['required', 'exists:categories,id'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['images'] = $this->parseImages($validated['images'] ?? null);

        $product->update($validated);

        return redirect()->route('seller.stock')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

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
}

