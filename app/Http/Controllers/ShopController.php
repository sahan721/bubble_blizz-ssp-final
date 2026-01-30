<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        // Get featured products or latest products for homepage
        $featuredProducts = Product::where('is_featured', true)
            ->take(8)
            ->get();
            
        $latestProducts = Product::latest()
            ->take(12)
            ->get();

        return view('shop.home', compact('featuredProducts', 'latestProducts'));
    }

    public function products(Request $request)
    {
        $query = Product::query();
        
        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->paginate(12);
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('shop.products', compact('products', 'categories'));
    }
}