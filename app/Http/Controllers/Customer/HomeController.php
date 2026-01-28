<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index(Request $request)
    {
        // show some products on home (latest / featured)
        $products = Product::query()
            ->orderByDesc('id')
            ->take(8)
            ->get();

        $favoriteIds = DB::table('favorites')
            ->where('user_id', Auth::id())
            ->pluck('product_id')
            ->toArray();

        return view('customer.home', compact('products', 'favoriteIds'));
    }
}
