<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\AddOn;

class OrderController extends Controller
{
    /**
     * Dodavanje proizvoda u korpu (sa opcijama)
     */
    public function addToCart(Request $request)
    {
        try {
            // Validator
            $validator = \Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'size' => 'nullable|in:mala,velika',
                'sos' => 'nullable|in:Tomato,Soja,Sečuan',
                'meat' => 'nullable|in:Piletina,Svinjetina',
                'addons' => 'array|nullable',
                'quantity' => 'required|integer|min:1',
                'notes' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $product = Product::findOrFail($request->product_id);

            $price = $product->price;

            // Doplata za veliku veličinu
            if ($request->size === 'velika') {
                $price += 200;
            }

            // Cena dodataka
            if (!empty($request->addons)) {
                $addonsPrice = AddOn::whereIn('id', $request->addons)->sum('price');
                $price += $addonsPrice;
            }

            $item = [
                'product_id' => $product->id,
                'name' => $product->name,
                'size' => $request->size ?? '',
                'sos' => $request->sos ?? '',
                'meat' => $request->meat ?? '',
                'addons' => $request->addons ?? [],
                'notes' => $request->notes ?? '',
                'quantity' => $request->quantity,
                'price' => $price * $request->quantity,
                'mix_rice' => $request->mix_rice ?? '',
            ];

            $cart = session('cart', []);
            $cart[] = $item;
            session(['cart' => $cart]);

            return response()->json([
                'success' => true,
                'message' => 'Proizvod dodat u korpu!',
                'cart_count' => count($cart),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Došlo je do greške na serveru: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Prikaz korpe
     */
    public function showCart()
    {
        $cart = session('cart', []);
        $productIds = array_column($cart, 'product_id');
        $products = Product::whereIn('id', $productIds)->get();

        return view('order.cart', compact('cart', 'products'));
    }


    /**
     * Checkout forma
    */
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('order.cart')->with('error', 'Vaša korpa je prazna.');
        }

        $user = auth()->user();

        return view('order.checkout', compact('cart', 'user'));
    }



    /**
     * Uklanjanje proizvoda iz korpe
     */
    public function removeFromOrder($index)
    {
        $cart = session('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
        }
        $cart = array_values($cart);
        session(['cart' => $cart]);

        return redirect()->route('order.cart')->with('success', 'Proizvod je uklonjen iz korpe.');
    }

    /**
     * Završavanje porudžbine
     */
    public function submitOrder(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Korpa je prazna.');
        }

        // Validator za guest podatke
        $validator = \Validator::make($request->all(), [
            'ime' => 'required|string|max:255',
            'telefon' => 'required|string|max:20',
            'adresa' => 'required|string|max:255',
            'napomena' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->check() ? auth()->id() : null, // ako je guest, ostaje null
                'status' => 'Primljena',
                'total_price' => array_sum(array_column($cart, 'price')),
                'ime' => $request->ime,
                'telefon' => $request->telefon,
                'adresa' => $request->adresa,
                'napomena' => $request->napomena,
            ]);

            foreach ($cart as $item) {
                $order->orderProducts()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'size' => $item['size'] ?? null,
                    'sos' => $item['sos'] ?? null,
                    'meat' => $item['meat'] ?? null,
                    'addons' => !empty($item['addons']) ? json_encode($item['addons']) : null,
                    'price' => $item['price'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('order.thankyou')->with('success', 'Porudžbina uspešno sačuvana!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Došlo je do greške: ' . $e->getMessage());
        }
    }



    /**
     * Thank you page
     */
    public function thankyou()
    {
        return view('order.thankyou');
    }
}
