<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class UserOrderController extends Controller
{
    // Prikaz svih narudžbina za prijavljenog korisnika
    public function index()
    {
        $user = Auth::user();

        // Uzmi sve narudžbine korisnika, sortirano po datumu opadajuće
        $orders = Order::with('products')->where('user_id', $user->id)->latest()->get();

        return view('user.orders.index', compact('orders'));
    }
}
