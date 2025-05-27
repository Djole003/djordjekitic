<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    // Definisanje tabele, ako se ne koristi konvencija
    protected $table = 'order_product'; 

    // Atributi koji mogu biti dodeljeni masovno
    protected $fillable = [
        'order_id', 'product_id', 'quantity',
    ];

    // Relacija sa proizvodima (inverznu relaciju)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relacija sa narudžbinama
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
