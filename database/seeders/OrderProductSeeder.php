<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OrderProductSeeder extends Seeder
{
    public function run()
    {
        // Uzmi ID-jeve narudžbina i proizvoda
        $orderIds = DB::table('orders')->pluck('id');
        $productIds = DB::table('products')->pluck('id');

        // Iteriraj kroz narudžbine
        foreach ($orderIds as $orderId) {
            // Poveži 2 proizvoda sa narudžbinom
            $selectedProducts = $productIds->random(2);

            foreach ($selectedProducts as $productId) {
                DB::table('order_product')->insert([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => rand(1, 5), // Random količina
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Ažuriraj `total_price` za svaku narudžbinu
            $totalPrice = DB::table('order_product')
                            ->where('order_id', $orderId)
                            ->join('products', 'order_product.product_id', '=', 'products.id')
                            ->sum(DB::raw('order_product.quantity * products.price'));

            DB::table('orders')->where('id', $orderId)->update([
                'total_price' => $totalPrice,
            ]);
        }
    }
}