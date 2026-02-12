<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class SellerReviewController extends Controller
{
public function index()
    {
        $sellerId = Auth::id();

        $reviews = Review::with(['user', 'product'])
            ->whereHas('product', function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->orderByDesc('created_at')
            ->paginate(15);
        $stats = [
            'total' => Review::whereHas('product', fn($q) => $q->where('user_id', $sellerId))->count(),
            'average_rating' => Review::whereHas('product', fn($q) => $q->where('user_id', $sellerId))->avg('rating') ?? 0,
            'approved' => Review::whereHas('product', fn($q) => $q->where('user_id', $sellerId))->where('moderation_status', 'approved')->count(),
            'pending' => Review::whereHas('product', fn($q) => $q->where('user_id', $sellerId))->where('moderation_status', 'pending')->count(),
        ];

        return view('seller.reviews', compact('reviews', 'stats'));
    }
}
