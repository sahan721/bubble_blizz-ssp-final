<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $juices = Product::where('category', 'juices')->orderBy('name')->get();
        $softDrinks = Product::where('category', 'soft-drinks')->orderBy('name')->get();
        $dairy = Product::where('category', 'dairy')->orderBy('name')->get();
        $energyDrinks = Product::where('category', 'energy-drinks')->orderBy('name')->get();

        $favoriteIds = Favorite::where('user_id', Auth::id())
            ->pluck('product_id')
            ->toArray();

        return view('customer.products', compact(
            'juices',
            'softDrinks',
            'dairy',
            'energyDrinks',
            'favoriteIds'
        ));
    }
}
