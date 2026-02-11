<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SellerNotificationController extends Controller
{
public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        $unreadCount = Auth::user()->unreadNotifications()->count();

        return view('seller.notifications', compact('notifications', 'unreadCount'));
    }
public function markAsRead(string $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marquée comme lue.');
    }
public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Toutes les notifications marquées comme lues.');
    }
}
