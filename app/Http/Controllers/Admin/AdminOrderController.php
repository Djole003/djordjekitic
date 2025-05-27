<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index() {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function edit(Order $order) {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order) {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Status narudžbine ažuriran.');
    }

    public function destroy(Order $order) {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Narudžbina obrisana.');
    }
}

