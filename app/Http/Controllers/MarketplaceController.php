<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
public function index(Request $request)
    {
        $query = Product::with(['category', 'vendor', 'reviews'])
            ->published()
            ->inStock();
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->withCount('orderItems')->orderByDesc('order_items_count');
                break;
            case 'newest':
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('buyer.marketplace', compact('products', 'categories'));
    }
}
