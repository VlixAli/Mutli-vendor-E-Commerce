<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->active()
            ->latest()
            ->limit(21)
            ->get();
        $categories = Category::all();
        return view('front.home', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
