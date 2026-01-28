<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
{
    $status = $request->query('status'); // Pending, Assigned, Picked Up, Delivered, Cancelled
    
    // Define available order statuses for the filter dropdown
    $statuses = ['Pending', 'Assigned', 'Picked Up', 'Delivered', 'Cancelled'];

    $ordersQuery = \App\Models\Order::with(['customer', 'rider']);

    // Filter
    if (!empty($status)) {
        $ordersQuery->where('status', $status);
    }

    // Shop-friendly sorting: Pending first, then newest
    $ordersQuery->orderByRaw("CASE
        WHEN status = 'Pending' THEN 0
        WHEN status = 'Assigned' THEN 1
        WHEN status = 'Picked Up' THEN 2
        WHEN status = 'Delivered' THEN 3
        WHEN status = 'Cancelled' THEN 4
        ELSE 5
    END")
    ->latest('created_at');

    $orders = $ordersQuery->paginate(10)->withQueryString();

    $riders = \App\Models\User::select('id', 'name', 'email')
        ->whereRaw("LOWER(role) = 'rider'")
        ->orderBy('name')
        ->get();

    return view('admin.orders.index', compact('orders', 'riders', 'status', 'statuses'));
}


    public function show(\App\Models\Order $order)
    {
        // Load the order with related models
        $order->load(['user', 'rider', 'items.product']);
        
        // Get available statuses and riders for the form
        $statuses = ['Pending', 'Assigned', 'Picked Up', 'Delivered', 'Cancelled'];
        $riders = \App\Models\User::select('id', 'name', 'email')
            ->whereRaw("LOWER(role) = 'rider'")
            ->orderBy('name')
            ->get();
        
        return view('admin.orders.show', compact('order', 'statuses', 'riders'));
    }

public function assign(\Illuminate\Http\Request $request, \App\Models\Order $order)
{
    // Lock completed/cancelled
    if (in_array($order->status, ['Delivered', 'Cancelled'], true)) {
        return back()->with('error', 'This order is locked and cannot be reassigned.');
    }

    $validated = $request->validate([
        'rider_id' => 'required|exists:users,id',
    ]);

    // Ensure selected user is actually a rider
    $rider = \App\Models\User::where('id', $validated['rider_id'])
        ->whereRaw("LOWER(role) = 'rider'")
        ->first();

    if (!$rider) {
        return back()->with('error', 'Selected user is not a rider.');
    }

    // Assign and update shop workflow fields
    $order->rider_id = $rider->id;

    // If order was Pending, move it to Assigned
    if ($order->status === 'Pending') {
        $order->status = 'Assigned';
    }

    // Always set assigned_at when assigning (or re-assigning)
    $order->assigned_at = now();

    $order->save();

    return back()->with('success', 'Rider assigned successfully.');
}

}
