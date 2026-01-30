<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiderController extends Controller
{
    public function index()
    {
        return $this->dashboard();
    }

    public function dashboard()
    {
        $riderId = Auth::id();
        $today = Carbon::today();

        $assignedCount = Order::where('rider_id', $riderId)
            ->whereIn('status', ['Assigned', 'Picked Up'])
            ->count();

        $deliveredTodayCount = Order::where('rider_id', $riderId)
            ->where('status', 'Delivered')
            ->whereDate('delivered_at', $today)
            ->count();

        $todayEarnings = Order::where('rider_id', $riderId)
            ->where('status', 'Delivered')
            ->whereDate('delivered_at', $today)
            ->sum(DB::raw('delivery_fee + tip'));

        $recentOrders = Order::with(['customer'])
            ->where('rider_id', $riderId)
            ->orderByDesc('id')
            ->take(8)
            ->get();

        return view('rider.dashboard', compact(
            'assignedCount',
            'deliveredTodayCount',
            'todayEarnings',
            'recentOrders'
        ));
    }

        public function orders()
    {
        $riderId = Auth::id();

        $orders = \App\Models\Order::with('customer')
            ->where('rider_id', $riderId)
            ->whereIn('status', ['Assigned', 'Picked Up'])
            ->latest('created_at')
            ->paginate(10);

        return view('rider.orders', compact('orders'));
    }



    public function earnings(Request $request)
    {
        $riderId = Auth::id();

        $from = $request->query('from');
        $to   = $request->query('to');

        $q = Order::where('rider_id', $riderId)
            ->where('status', 'Delivered')
            ->orderByDesc('delivered_at');

        if ($from) $q->whereDate('delivered_at', '>=', $from);
        if ($to)   $q->whereDate('delivered_at', '<=', $to);

        $earningsOrders = $q->paginate(10)->withQueryString();

        $totalEarnings = (clone $q)->sum(DB::raw('delivery_fee + tip'));

        return view('rider.earnings', compact('earningsOrders', 'totalEarnings', 'from', 'to'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('rider.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }


    public function markPickedUp(Order $order)
    {
        $this->authorizeRiderOrder($order);

        if ($order->status !== 'Assigned') {
            return back()->with('error', 'Only Assigned orders can be marked as Picked Up.');
        }

        $order->update([
            'status' => 'Picked Up',
            'picked_up_at' => now(),
        ]);

        return back()->with('success', 'Order marked as Picked Up.');
    }

    public function markDelivered(Order $order)
    {
        $this->authorizeRiderOrder($order);

        if ($order->status !== 'Picked Up') {
            return back()->with('error', 'Only Picked Up orders can be marked as Delivered.');
        }

        $order->update([
            'status' => 'Delivered',
            'delivered_at' => now(),
        ]);

        return back()->with('success', 'Order marked as Delivered.');
    }

    private function authorizeRiderOrder(Order $order): void
    {
        if ((int) $order->rider_id !== (int) Auth::id()) {
            abort(403, 'This order is not assigned to you.');
        }
    }

        public function history()
    {
        $riderId = Auth::id();

        $orders = \App\Models\Order::with('customer')
            ->where('rider_id', $riderId)
            ->whereIn('status', ['Delivered']) // add 'Cancelled' if you want
            ->latest('delivered_at')
            ->paginate(10);

        return view('rider.orders-history', compact('orders'));
    }

}
    