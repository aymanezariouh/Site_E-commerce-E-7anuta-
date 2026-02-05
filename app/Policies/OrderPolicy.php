<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine if the seller can view this order.
     * A seller can view orders that contain their products.
     */
    public function viewForSeller(User $user, Order $order): bool
    {
        return $order->items()
            ->whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->exists();
    }

    /**
     * Determine if the seller can update the order status.
     */
    public function updateStatus(User $user, Order $order): bool
    {
        return $this->viewForSeller($user, $order);
    }
}
