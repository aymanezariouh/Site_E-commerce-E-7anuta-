<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    public function orders()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        
        // Set timestamps based on status
        if ($request->status == 'shipped' && $oldStatus != 'shipped') {
            $order->shipped_at = now();
        } elseif ($request->status == 'delivered' && $oldStatus != 'delivered') {
            $order->delivered_at = now();
            if (!$order->shipped_at) {
                $order->shipped_at = now();
            }
        }
        
        $order->save();

        return redirect()->back()->with('success', 'Order status updated and email notification sent!');
    }
}