<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Prikaz admin panela narudžbina sa dve kolone
    public function index()
    {
        // Narudžbine koje čekaju da budu prihvaćene
        $pendingOrders = Order::with('user', 'products.addons')
            ->where('status', 'na čekanju')
            ->orderBy('created_at', 'desc')
            ->get();

        // Narudžbine koje su prihvaćene i u pripremi/dostavi
        $acceptedOrders = Order::with('user', 'products.addons')
            ->whereIn('status', ['prihvaćena', 'dostavlja se'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('pendingOrders', 'acceptedOrders'));
    }

    // Prihvatanje narudžbine i definisanje vremena pripreme
    public function accept($id, Request $request)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'preparation_time' => 'required|integer|min:15|max:60',
        ]);

        $order->status = 'prihvaćena';
        $order->preparation_time = $request->preparation_time; // u minutima
        $order->save();

        return redirect()->back()->with('success', 'Narudžbina prihvaćena.');
    }

    // Označavanje narudžbine kao dostavlja se
    public function deliver($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'dostavlja se';
        $order->save();

        return redirect()->back()->with('success', 'Narudžbina je sada u dostavi.');
    }

    // Označavanje narudžbine kao isporučena
    public function delivered($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'isporučeno';
        $order->save();

        return redirect()->back()->with('success', 'Narudžbina isporučena.');
    }

    // Brisanje narudžbine
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Narudžbina obrisana.');
    }
}
