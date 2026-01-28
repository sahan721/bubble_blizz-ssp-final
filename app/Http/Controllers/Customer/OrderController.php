<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
    public function place(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'payment_method' => 'required|string|max:100',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $qty = (int) ($item['qty'] ?? 1);
            $price = (float) ($item['price'] ?? 0);
            $total += ($qty * $price);
        }

        DB::transaction(function () use ($request, $total) {
            Order::create([
                'user_id' => Auth::id(),
                'status' => 'Pending',
                'total' => $total,
                'delivery_address' => $request->address,
                'payment_method' => $request->payment_method,
            ]);

            session()->forget('cart');
        });

        return redirect()->route('customer.orders')
            ->with('success', 'Order placed successfully! Waiting for admin assignment.');
    }
}
