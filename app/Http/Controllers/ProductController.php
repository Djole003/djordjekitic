<?php

namespace App\Http\Controllers;


use App\Models\OrderProduct;
use App\Models\Product; 
use Illuminate\Http\Request;
use DB; 

class ProductController extends Controller
{
    public function index()
    {
        // Povlačimo najpopularnija jela
        $popularDishes = Product::select('products.id', 'products.name', 'products.image_path', DB::raw('COUNT(order_product.product_id) as total_orders'))
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->groupBy('products.id', 'products.name', 'products.image_path')
            ->orderByDesc('total_orders')
            ->limit(6) 
            ->get();

        
        return view('index', compact('popularDishes'));
    }

    // Prikaz celog jelovnika (kataloga)
    public function jelovnik()
    {
        $jela = Product::all(); 
        return view('jelovnik.index', compact('jela'));
    }

    // Prikaz detalja pojedinačnog jela
    public function show($id)
    {
        $jelo = Product::findOrFail($id); 
        return view('jelovnik.show', compact('jelo'));
    }

    public function jelovnikPoKategorijama()
    {
        
        $productsByCategory = Product::all()->groupBy('category');

        
        return view('jelovnik.jelovnik', compact('productsByCategory'));
    }

    public function showWithSuggestions($id)
    {
        $jelo = Product::findOrFail($id);

        $pice = Product::where('category', 'Piće')
                    ->where('id', '!=', $id)
                    ->take(3)
                    ->get();

        $dezerti = Product::where('category', 'Dezert')
                        ->where('id', '!=', $id)
                        ->take(3)
                        ->get();

        $preporuceno = Product::where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('jelovnik.show_with_suggestions', compact('jelo', 'pice', 'dezerti','preporuceno'));
    }






}
