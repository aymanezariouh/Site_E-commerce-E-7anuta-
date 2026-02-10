<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use App\Notifications\AdminAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SellerOrderController extends Controller
{
    private const SELLER_STATUS_TO_DB = [
        'pending' => 'pending',
        'accepted' => 'processing',
        'shipped' => 'shipped',
    ];

    private const SELLER_STATUS_LABELS = [
        'pending' => 'Pending',
        'accepted' => 'Accepted',
        'shipped' => 'Shipped',
    ];

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
        $availableStatuses = $this->sellerAvailableStatuses($order->status);

        return view('seller.order-details', compact('order', 'sellerItems', 'sellerTotal', 'availableStatuses'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('updateStatus', $order);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,accepted,shipped'],
        ]);

        $allowedStatuses = $this->sellerAvailableStatuses($order->status);
        if (!in_array($validated['status'], $allowedStatuses, true)) {
            return redirect()->back()->with('error', 'This status transition is not allowed for sellers.');
        }

        $targetStatus = $this->sellerStatusToDatabaseStatus($validated['status']);

        if (!$order->canTransitionTo($targetStatus)) {
            return redirect()->back()->with('error', 'This status transition is invalid.');
        }

        $oldStatus = $order->status;
        $order->status = $targetStatus;

        // Set timestamps based on status
        if ($targetStatus === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = now();
        }
        if ($targetStatus === 'delivered' && !$order->delivered_at) {
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

        $admins = User::role('admin')->whereKeyNot(Auth::id())->get();
        if ($admins->isNotEmpty()) {
            Notification::send(
                $admins,
                new AdminAlertNotification(
                    'order_status_changed',
                    'Statut de commande #' . $order->order_number . ' : ' . $oldStatus . ' -> ' . $order->status,
                    route('admin.orders.show', $order)
                )
            );
        }

        $oldStatusLabel = $this->databaseStatusToSellerStatus($oldStatus);
        $newStatusLabel = $this->databaseStatusToSellerStatus($targetStatus);

        return redirect()->back()->with('success', "Order status updated: {$oldStatusLabel} -> {$newStatusLabel}");
    }

    private function sellerAvailableStatuses(string $databaseStatus): array
    {
        return match ($databaseStatus) {
            'pending' => ['accepted'],
            'processing' => ['shipped'],
            default => [],
        };
    }

    private function sellerStatusToDatabaseStatus(string $sellerStatus): string
    {
        return self::SELLER_STATUS_TO_DB[$sellerStatus] ?? $sellerStatus;
    }

    private function databaseStatusToSellerStatus(string $databaseStatus): string
    {
        $sellerStatus = array_search($databaseStatus, self::SELLER_STATUS_TO_DB, true);

        if (is_string($sellerStatus) && isset(self::SELLER_STATUS_LABELS[$sellerStatus])) {
            return self::SELLER_STATUS_LABELS[$sellerStatus];
        }

        return ucfirst($databaseStatus);
    }
}
