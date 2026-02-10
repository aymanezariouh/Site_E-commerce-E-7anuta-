<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends Controller
{
    public function reviews()
    {
        $reviews = Review::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('moderator.reviews', compact('reviews'));
    }

    public function hideReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => false]);
        
        return redirect()->back()->with('success', 'Review hidden successfully!');
    }

    public function showReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'Review shown successfully!');
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    public function users()
    {
        $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(20);
        return view('moderator.users', compact('users'));
    }

    public function suspendUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->update(['deleted_at' => now()]);
        
        return redirect()->back()->with('success', 'User suspended successfully!');
    }

    public function unsuspendUser($id)
    {
        $user = \App\Models\User::withTrashed()->findOrFail($id);
        $user->restore();
        
        return redirect()->back()->with('success', 'User unsuspended successfully!');
    }

    public function products()
    {
        $products = \App\Models\Product::with('category')->orderBy('created_at', 'desc')->paginate(20);
        return view('moderator.products', compact('products'));
    }

    public function suspendProduct($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->update(['is_active' => false]);
        
        return redirect()->back()->with('success', 'Product suspended successfully!');
    }

    public function unsuspendProduct($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->update(['is_active' => true]);
        
        return redirect()->back()->with('success', 'Product unsuspended successfully!');
    }
}
