<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    /**
     * Display a list of orders containing the seller's products.
     */
    public function index()
    {
        $sellerId = Auth::id();

        // Get orders that contain at least one product from this seller
        $orders = Order::with(['user', 'items.product'])
            ->whereHas('items.product', function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        // Calculate seller's portion for each order
        $orders->getCollection()->transform(function ($order) use ($sellerId) {
            $sellerItems = $order->items->filter(function ($item) use ($sellerId) {
                return $item->product && $item->product->user_id === $sellerId;
            });

            $order->seller_total = $sellerItems->sum('total_price');
            $order->seller_items_count = $sellerItems->count();

            return $order;
        });

        return view('seller.orders', compact('orders'));
    }

    /**
     * Display order details.
     */
    public function show(Order $order)
    {
        $this->authorize('viewForSeller', $order);

        $sellerId = Auth::id();

        $order->load(['user', 'items.product', 'payments', 'statusHistories.user']);

        // Filter items to show only seller's products
        $sellerItems = $order->items->filter(function ($item) use ($sellerId) {
            return $item->product && $item->product->user_id === $sellerId;
        });

        $sellerTotal = $sellerItems->sum('total_price');

        $availableStatuses = array_filter(
            ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'],
            fn ($status) => $order->canTransitionTo($status)
        );

        return view('seller.order-details', compact('order', 'sellerItems', 'sellerTotal', 'availableStatuses'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,delivered,cancelled,refunded'],
        ]);

        if (!$order->canTransitionTo($validated['status'])) {
            return redirect()->back()->with('error', 'Transition de statut non autorisée.');
        }

        $oldStatus = $order->status;
        $order->status = $validated['status'];

        // Set timestamps based on status
        if ($validated['status'] === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = now();
        }
        if ($validated['status'] === 'delivered' && !$order->delivered_at) {
            $order->delivered_at = now();
        }

        $order->save();

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'old_status' => $oldStatus,
            'new_status' => $order->status,
            'note' => 'Seller status update',
        ]);

        $order->loadMissing('user');
        if ($order->user) {
            $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order, $oldStatus));
        }

        return redirect()->back()->with('success', "Statut de commande mis à jour : {$oldStatus} → {$validated['status']}");
    }
}
