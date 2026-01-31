<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Get the category from query parameter
        $category = $request->query('category');
        
        // Get all products for the Livewire component to handle
        $products = Product::all();
        
        // Handle guests vs authenticated users
        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        } else {
            $favoriteIds = [];
        }

        return view('customer.products', compact(
            'products',
            'favoriteIds',
            'category'
        ));
    }
}