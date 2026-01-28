<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function home()
    {
        $totalOrders = Order::count();

        $pending = Order::where('status', 'Pending')->count();
        $assigned = Order::where('status', 'Assigned')->count();
        $pickedUp = Order::where('status', 'Picked Up')->count();
        $delivered = Order::where('status', 'Delivered')->count();

        $riders = User::whereRaw('LOWER(role) = ?', ['rider'])->count();
        $customers = User::whereRaw('LOWER(role) = ?', ['customer'])->count();

        $recentOrders = Order::with(['customer', 'rider'])
            ->orderByDesc('id')
            ->take(8)
            ->get();

        return view('admin.home', compact(
            'totalOrders', 'pending', 'assigned', 'pickedUp', 'delivered',
            'riders', 'customers', 'recentOrders'
        ));
    }
}
