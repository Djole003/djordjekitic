<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\AddOn;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Početna stranica
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Jelovnik sa najpopularnijim jelima i grupisanjem po kategorijama
     */
    public function jelovnikPoKategorijama()
    {
        // 5 najpopularnijih jela
        $popularDishes = Product::select(
                'products.id',
                'products.name',
                'products.image_path',
                'products.price',
                'products.description',
                \DB::raw('COUNT(order_product.product_id) as total_orders')
            )
            ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->groupBy('products.id', 'products.name', 'products.image_path', 'products.price', 'products.description')
            ->orderByDesc('total_orders')
            ->limit(5)
            ->get();

        // Svi proizvodi sa kategorijama učitanim
        $products = Product::with('category')->get();

        // Dodaci
        $addons = AddOn::all();

        // Grupisanje po kategorijama (koristeći prave modele)
        $productsByCategory = $products->groupBy(function($product){
            return $product->category->name;
        });

        // Lista kategorija (pravi modeli)
        $categories = Category::all();

        return view('jelovnik.jelovnik', compact('popularDishes', 'productsByCategory', 'addons', 'categories'));
    }

    /**
     * Detalji jela sa predlozima
     */
    public function showWithSuggestions($id)
    {
        $jelo = Product::findOrFail($id);

        $pice = Product::whereHas('category', function($q){
                    $q->where('name', 'Piće');
                })->where('id', '!=', $id)
                  ->take(3)
                  ->get();

        $dezerti = Product::whereHas('category', function($q){
                    $q->where('name', 'Dezerti');
                })->where('id', '!=', $id)
                  ->take(3)
                  ->get();

        $preporuceno = Product::where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('jelovnik.show_with_suggestions', compact('jelo', 'pice', 'dezerti', 'preporuceno'));
    }

    /**
     * Prikaz proizvoda po kategoriji
     */
  public function showCategory($slug)
    {
        // Pronalazi kategoriju po slug-u ili baca 404
        $category = Category::where('slug', $slug)->firstOrFail();

        // Uzimamo sve proizvode te kategorije
        $products = $category->products;

        // Uzimamo sve dodatke da se prikažu u modal formi
        $addons = AddOn::all();

        // Prosleđujemo view-u sve potrebne promenljive
        return view('jelovnik.kategorija', compact('category', 'products', 'addons'));
    }

}
