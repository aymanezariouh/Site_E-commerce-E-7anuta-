<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderStatusChanged;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        // جبدنا order بالـ id
        $order = Order::findOrFail($id);

        // بدلنا status
        $order->status = $request->status;
        $order->save();

        // بعث notification للعميل
        $order->user->notify(new OrderStatusChanged($order));

        return redirect()->back()->with('success', 'Statut mis à jour et email envoyé au client.');
    }
}
