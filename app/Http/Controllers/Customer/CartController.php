<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []); // [product_id => qty]

        $productIds = array_keys($cart);

        $products = Product::query()
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $items = [];
        $total = 0;

        foreach ($cart as $id => $qty) {
            if (!isset($products[$id])) continue;

            $p = $products[$id];

            $price = (float) $p->price;
            $line  = $price * (int) $qty;
            $total += $line;

            $items[] = [
                'id'    => $p->id,
                'name'  => $p->name,
                'desc'  => $p->description ?? '',
                'price' => $price,
                'qty'   => (int) $qty,
                'line'  => $line,
                'stock' => (int) ($p->stock ?? 0),
                'image' => $p->image ?? null,
            ];
        }

        return view('customer.cart', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'qty'        => ['nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $id  = (int) $request->input('product_id');
        $qty = (int) ($request->input('qty') ?? 1);

        $product = Product::findOrFail($id);

        // ✅ optional stock protection
        $stock = (int) ($product->stock ?? 0);

        $cart = $request->session()->get('cart', []);
        $newQty = ($cart[$id] ?? 0) + $qty;

        if ($stock > 0 && $newQty > $stock) {
            $newQty = $stock;
        }

        $cart[$id] = $newQty;
        $request->session()->put('cart', $cart);

        return back()->with('status', 'Added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
            'qty'        => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        $id  = (int) $request->input('product_id');
        $qty = (int) $request->input('qty');

        $cart = $request->session()->get('cart', []);

        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            // ✅ optional stock protection
            $product = Product::find($id);
            if ($product) {
                $stock = (int) ($product->stock ?? 0);
                if ($stock > 0 && $qty > $stock) {
                    $qty = $stock;
                }
            }
            $cart[$id] = $qty;
        }

        $request->session()->put('cart', $cart);
        return back();
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $id = (int) $request->input('product_id');

        $cart = $request->session()->get('cart', []);
        unset($cart[$id]);
        $request->session()->put('cart', $cart);

        return back();
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return back();
    }
}
