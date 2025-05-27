<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity');
    }


    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image_path',
    ];
    protected $table = 'products';

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }
}
