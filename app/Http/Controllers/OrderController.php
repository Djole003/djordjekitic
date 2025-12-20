<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Dodavanje proizvoda u korpu
     */
    public function addToCart(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|in:mala,velika',
            'sos' => 'nullable|string',
            'meat' => 'nullable|string',
            'addons' => 'array|nullable',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
            'mix_rice' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $product   = Product::findOrFail($request->product_id);
        $orderType = session('order_type', 'delivery');

        // Osnovna cena
        $price = $orderType === 'delivery'
            ? $product->price_delivery
            : $product->price_takeaway;

        // Velika porcija
        if ($request->size === 'velika') {
            $price += 200;
        }

        // Dodaci (samo id-evi se čuvaju, cena se računa kasnije)
        $addons = $request->addons ?? [];

        $item = [
            'product_id' => $product->id,
            'name'       => $product->name,
            'quantity'   => $request->quantity,
            'details' => [
                'size'     => $request->size,
                'sos'      => $request->sos,
                'meat'     => $request->meat,
                'addons'   => $addons,
                'notes'    => $request->notes,
                'mix_rice' => $request->mix_rice,
            ],
        ];

        $cart = session('cart', []);
        $cart[] = $item;

        session(['cart' => $cart]);

        return response()->json([
            'success'    => true,
            'message'    => 'Proizvod dodat u korpu',
            'cart_count' => count($cart),
        ]);
    }



    /**
     * Prikaz korpe
     */
    public function showCart()
    {
        return view('order.cart', [
            'cart' => session('cart', [])
        ]);
    }

    /**
     * Checkout
     */
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('order.cart');
        }

        return view('order.checkout', [
            'cart' => $cart,
            'user' => auth()->user(),
        ]);
    }

    /**
     * Slanje porudžbine
     */
    public function submitOrder(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Korpa je prazna.');
        }

        DB::beginTransaction();

        try {
            $orderType = session('order_type', 'delivery');

            $order = Order::create([
                'user_id'       => auth()->id(),
                'status'        => 'Primljena',
                'order_type'    => $orderType,
                'total_price'   => 0, // kasnije ćemo izračunati
                'delivery_info' => json_encode([
                    'ime'      => $request->ime,
                    'telefon'  => $orderType === 'delivery' ? $request->telefon : null,
                    'adresa'   => $orderType === 'delivery' ? $request->adresa : null,
                    'napomena' => $request->napomena,
                ]),
            ]);

            foreach ($cart as $item) {
                $order->orderProducts()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'details'    => json_encode($item['details']),
                ]);
            }

            // Osveži relacije
            $order->refresh()->load('orderProducts.product');

            // Izračunaj tačnu cenu
            $order->update([
                'total_price' => $order->calculateTotalPrice()
            ]);

            DB::commit();
            session()->forget('cart');

            return redirect()->route('order.thankyou');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
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
