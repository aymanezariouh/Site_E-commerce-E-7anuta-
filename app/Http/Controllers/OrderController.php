<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderStatusChanged;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        // jbedena order b id
        $order = Order::findOrFail($id);

        // change status
        $order->status = $request->status;
        $order->save();

        // send notification le3amil
        $order->user->notify(new OrderStatusChanged($order));

        return redirect()->back()->with('success', 'Statut mis à jour et email envoyé au client.');
    }
}
