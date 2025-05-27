<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Dodavanje proizvoda u korpu (sesiju)
    public function addToOrder($id)
    {

        //dd("Dodajem proizvod sa ID: $id");
        $product = Product::findOrFail($id);
        $korpa = session()->get('order', []);

        $postoji = false;
        foreach ($korpa as &$item) {
            if ($item['id'] == $id) {
                $item['kolicina'] += 1;
                $postoji = true;
                break;
            }
        }
        if (!$postoji) {
            $korpa[] = [
                'id' => $id,
                'kolicina' => 1,
                'cena' => $product->price,
            ];
        }

        session(['order' => $korpa]);

        return redirect()->back()->with('success', 'Proizvod dodat u korpu!');
    }

    // Završavanje porudžbine i upis u bazu
    public function submitOrder()
    {
        $korpa = session('order');

        if (!$korpa || count($korpa) == 0) {
            return redirect()->back()->with('error', 'Korpa je prazna.');
        }

        DB::beginTransaction();

        try {
            // Kreiraj order bez total_price (ili sa 0)
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'Primljena',
                'total_price' => 0,
            ]);

            // Dodaj proizvode u order_product pivot tabelu
            foreach ($korpa as $item) {
                $order->orderProducts()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['kolicina'],
                ]);
            }

            // Ručno izračunaj i update-uj total_price
            $totalPrice = $order->calculateTotalPrice();
            $order->total_price = $totalPrice;
            $order->save();

            DB::commit();

            session()->forget('order');

            return redirect()->route('order.thankyou')->with('success', 'Porudžbina uspešno sačuvana!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Došlo je do greške: ' . $e->getMessage());
        }
    }



    

    public function showCart()
    {
        $korpa = session('order', []);
        // Možeš učitati i detalje proizvoda iz baze da bi prikazao ime, cenu itd.
        $productIds = array_column($korpa, 'id');
        $proizvodi = Product::whereIn('id', $productIds)->get();

        // Spremi količine u asocijativni niz id => kolicina
        $kolicine = [];
        foreach ($korpa as $item) {
            $kolicine[$item['id']] = $item['kolicina'];
        }

        return view('order.cart', compact('proizvodi', 'kolicine'));
    }

    public function removeFromOrder($id)
    {
        $korpa = session()->get('order', []);

        foreach ($korpa as $key => $item) {
            if ($item['id'] == $id) {
                unset($korpa[$key]);
                break;
            }
        }

        // Reindeksiraj niz da nema praznih ključeva
        $korpa = array_values($korpa);

        session(['order' => $korpa]);

        return redirect()->route('order.cart')->with('success', 'Proizvod je uklonjen iz korpe.');
    }

    public function thankyou()
    {
        return view('order.thankyou');
    }


}
