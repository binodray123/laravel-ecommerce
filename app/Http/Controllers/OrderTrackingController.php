<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    // public function track($orderId)
    // {
    //     $order = Order::with('scans')
    //         ->where('id', $orderId)
    //         ->where('user_id', Auth::id())
    //         ->firstOrFail();

    //     $scans = $order->scans->sortByDesc('scan_time')->groupBy(function ($scan) {
    //         return \Carbon\Carbon::parse($scan->scan_time)->format('l, d F');
    //     });

    //     return view('user.order-tracking', compact('order', 'scans'));
    // }

    public function track($orderId)
    {
        $order = Order::with('user')->findOrFail($orderId);

        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        return view('user.order-tracking', compact('order'));
    }
}
