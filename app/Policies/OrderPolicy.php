<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
public function viewForSeller(User $user, Order $order): bool
    {
        return $order->items()
            ->whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->exists();
    }
public function updateStatus(User $user, Order $order): bool
    {
        return $this->viewForSeller($user, $order);
    }
}
