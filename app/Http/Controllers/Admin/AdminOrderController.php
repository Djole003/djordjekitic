<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Prikaz admin panela narudžbina
     * - Levo: na čekanju
     * - Sredina: u pripremi
     * - Desno: dostavlja se
     */
    public function index()
    {
        $waitingOrders = Order::with('orderProducts.product')
            ->where('status', 'na cekanju')
            ->orderBy('created_at', 'asc')
            ->get();

        $preparingOrders = Order::with('orderProducts.product')
            ->where('status', 'u pripremi')
            ->orderBy('ready_at', 'asc')
            ->get();

        $deliveringOrders = Order::with('orderProducts.product')
            ->where('status', 'dostavlja se')
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('admin.orders.index', compact(
            'waitingOrders',
            'preparingOrders',
            'deliveringOrders'
        ));
    }

    /**
     * Prihvatanje narudžbine
     * Status: na cekanju -> u pripremi
     */
    public function accept(Request $request, $id)
    {
        $request->validate([
            'preparation_time' => 'required|integer|min:1|max:180',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'u pripremi',
            'preparation_time' => $request->preparation_time,
            'ready_at' => now()->addMinutes($request->preparation_time),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Narudžbina prihvaćena'
        ]);
    }

    /**
     * Klik na dugme "Spremno"
     * Status: u pripremi -> dostavlja se
     */
    public function ready($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'dostavlja se',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Narudžbina spremna za dostavu'
        ]);
    }

    /**
     * Automatsko završavanje narudžbina
     * (poziva se preko cron-a ili scheduler-a)
     */
    public function finishOrders()
    {
        Order::where('status', 'dostavlja se')
            ->whereNotNull('ready_at')
            ->where('ready_at', '<=', now())
            ->update([
                'status' => 'zavrsena'
            ]);
    }
}
