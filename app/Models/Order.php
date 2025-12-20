<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'delivery_info',
        'order_type',
        'ime',
        'telefon',
        'adresa',
        'napomena',
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Računa ukupnu cenu porudžbine na osnovu tipa porudžbine i opcija
     */
    public function calculateTotalPrice()
    {
        // Učitaj relacije ako već nisu
        $this->loadMissing('orderProducts.product');

        $totalPrice = 0;
        $orderType = $this->order_type ?? 'delivery';

        foreach ($this->orderProducts as $orderItem) {
            $product = $orderItem->product;
            if (!$product) continue;

            // Osnovna cena po tipu porudžbine
            $price = $orderType === 'delivery' ? $product->price_delivery : $product->price_takeaway;

            // Dekodiraj details JSON
            $details = json_decode($orderItem->details, true) ?? [];

            // Velika porcija
            if (($details['size'] ?? null) === 'velika') {
                $price += 200;
            }

            // Dodaci iz baze
            $addonsPrice = 0;
            $addonIds = $details['addons'] ?? [];
            if (!empty($addonIds)) {
                $addons = \App\Models\AddOn::whereIn('id', $addonIds)->get();
                foreach ($addons as $addon) {
                    $addonsPrice += $addon->price;
                }
            }

            $totalPrice += ($price + $addonsPrice) * $orderItem->quantity;
        }

        return $totalPrice;
    }




}
