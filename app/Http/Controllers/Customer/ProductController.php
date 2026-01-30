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
        
        // Get favorite IDs for the current user
        $favoriteIds = Favorite::where('user_id', Auth::id())
            ->pluck('product_id')
            ->toArray();

        return view('customer.products', compact(
            'products',
            'favoriteIds',
            'category'
        ));
    }
}