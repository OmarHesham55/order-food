<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
    {
        $orders = Order::with('restaurant')->get();
        return view('admin.orders.index',compact('orders'));
    }
    public function orderStatus(Request $request,Order $order)
    {
        $request->validate([
            'status' => 'required'
        ]);
        $order = Order::findOrFail($request->orderId);
        $order->update([
            'status' => $request->status
        ]);
        return response()->json([
            'status' => 'success'
        ],200);
    }
}
