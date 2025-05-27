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
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity');
    }
    

    public function calculateTotalPrice()
    {
        $totalPrice = 0;

        foreach ($this->products as $product) {
            // Računanje ukupne cene (cena * količina)
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        return $totalPrice;
    }

    // Kada se kreira ili ažurira narudžbina, izračunaj ukupnu cenu


    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
