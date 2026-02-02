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
       
        $riderId = Auth::id();
        $today = Carbon::today();

        // Assigned (includes picked up because rider is still working on it)
        $assignedCount = Order::where('rider_id', $riderId)
            ->whereIn('status', ['Assigned', 'Picked Up'])
            ->count();

        // Pending Delivery = picked up and not delivered yet
        $pendingDeliveryCount = Order::where('rider_id', $riderId)
            ->where('status', 'Picked Up')
            ->count();

        // Delivered today
        $deliveredTodayCount = Order::where('rider_id', $riderId)
            ->where('status', 'Delivered')
            ->whereDate('delivered_at', $today)
            ->count();

        // Earnings today (delivery_fee + tip)
        $todayEarnings = Order::where('rider_id', $riderId)
            ->where('status', 'Delivered')
            ->whereDate('delivered_at', $today)
            ->sum(DB::raw('delivery_fee + tip'));

        // Safe fallbacks
        $assignedCount = (int) ($assignedCount ?? 0);
        $pendingDeliveryCount = (int) ($pendingDeliveryCount ?? 0);
        $deliveredTodayCount = (int) ($deliveredTodayCount ?? 0);
        $todayEarnings = (float) ($todayEarnings ?? 0);

        $recentOrders = Order::with(['customer'])
            ->where('rider_id', $riderId)
            ->orderByDesc('id')
            ->take(8)
            ->get();

        if (!$recentOrders instanceof \Illuminate\Support\Collection) {
            $recentOrders = collect([]);
        }

        return view('rider.dashboard', compact(
            'assignedCount',
            'pendingDeliveryCount',
            'deliveredTodayCount',
            'todayEarnings',
            'recentOrders'
        ));
    }

    /**
     * Accept a pending order.
     * IMPORTANT: Pending orders often have rider_id = null, so we must NOT authorize by rider_id first.
     */
    public function acceptOrder(Order $order)
    {
        // Only pending orders can be accepted
        if ($order->status !== 'Pending') {
            return back()->with('error', 'Only pending orders can be accepted.');
        }

        // If already assigned to another rider, block
        if (!is_null($order->rider_id) && (int) $order->rider_id !== (int) Auth::id()) {
            abort(403, 'This order is assigned to another rider.');
        }

        // Assign to current rider and mark assigned
        $order->update([
            'rider_id' => Auth::id(),
            'status' => 'Assigned',
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Order accepted successfully.');
    }

    public function pickupOrder(Order $order)
    {
        return $this->markPickedUp($order);
    }

    public function deliverOrder(Order $order)
    {
        return $this->markDelivered($order);
    }

    public function orders()
    {
        $riderId = Auth::id();

        $orders = Order::with('customer')
            ->where('rider_id', $riderId)
            ->whereIn('status', ['Assigned', 'Picked Up'])
            ->latest('created_at')
            ->paginate(10);

        return view('rider.orders', compact('orders'));
    }

    public function history()
    {
        $riderId = Auth::id();

        $orders = Order::with('customer')
            ->where('rider_id', $riderId)
            ->whereIn('status', ['Delivered']) // add 'Cancelled' if you want
            ->latest('delivered_at')
            ->paginate(10);

        return view('rider.orders-history', compact('orders'));
    }

    public function earnings(Request $request)
    {
        $riderId = Auth::id();

        $from = $request->query('from');
        $to   = $request->query('to');

        $q = Order::where('rider_id', $riderId)
            ->where('status', 'Delivered')
            ->orderByDesc('delivered_at');

        if ($from) {
            $q->whereDate('delivered_at', '>=', $from);
        }
        if ($to) {
            $q->whereDate('delivered_at', '<=', $to);
        }

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
        $user = Auth::user();

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
}
