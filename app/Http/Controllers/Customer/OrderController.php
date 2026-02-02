<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ✅ SHOW CUSTOMER ORDERS
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    // ✅ PLACE ORDER
    // ✅ STORE ORDER
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'payment_method' => 'required|string|max:100',
        ]);

        $cart = session('cart', []); // [product_id => qty]

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Fetch products to get current prices and ensure they exist
        $products = \App\Models\Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        
        $total = 0;
        $orderItemsData = [];

        foreach ($cart as $id => $qty) {
            if (!isset($products[$id])) continue;

            $product = $products[$id];
            $price = (float) $product->price;
            $qty = (int) $qty;
            $lineTotal = $price * $qty;
            
            $total += $lineTotal;

            $orderItemsData[] = [
                'product_id' => $product->id,
                'qty' => $qty,
                'unit_price' => $price,
                'line_total' => $lineTotal,
            ];
        }

        if (empty($orderItemsData)) {
            return back()->with('error', 'No valid items in cart found.');
        }

        DB::transaction(function () use ($request, $total, $orderItemsData) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'Pending',
                'total' => $total,
                'delivery_address' => $request->address,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($orderItemsData as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['line_total'],
                ]);
            }

            session()->forget('cart');
        });

        return redirect()->route('customer.orders.index')
            ->with('success', 'Order placed successfully! Waiting for admin assignment.');
    }
}
