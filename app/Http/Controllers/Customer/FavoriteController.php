<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Show favorite products
     */
    public function index()
    {
        $userId = Auth::id();

        $products = Product::query()
            ->join('favorites', 'favorites.product_id', '=', 'products.id')
            ->where('favorites.user_id', $userId)
            ->select('products.*')
            ->orderBy('products.name')
            ->get();

        return view('customer.favorites', compact('products'));
    }

    /**
     * Add / remove favorite
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $userId = Auth::id();
        $productId = (int) $request->product_id;

        $exists = DB::table('favorites')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            DB::table('favorites')
                ->where('user_id', $userId)
                ->where('product_id', $productId)
                ->delete();

            return back()->with('status', 'Removed from favorites');
        }

        DB::table('favorites')->insert([
            'user_id' => $userId,
            'product_id' => $productId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('status', 'Added to favorites');
    }
}
