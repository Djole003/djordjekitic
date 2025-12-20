<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price_delivery', // nova kolona
        'price_takeaway', // nova kolona
        'image_path',
        'category_id', // veza sa kategorijom
    ];

    /**
     * Accessor za pravu cenu u zavisnosti od tipa porudžbine
     */
    public function getPriceAttribute()
    {
        $type = session('order_type', 'delivery'); // default je delivery
        return $type === 'takeaway' ? $this->price_takeaway : $this->price_delivery;
    }

    /**
     * Veza sa kategorijom
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Veza sa porudžbinama (many-to-many)
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity');
    }

    /**
     * Veza sa order_product (jedan-na-više)
     */
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }

    /**
     * Veza sa dodacima (many-to-many)
     */
    public function addOns()
    {
        return $this->belongsToMany(\App\Models\AddOn::class, 'product_add_on');
    }
}
