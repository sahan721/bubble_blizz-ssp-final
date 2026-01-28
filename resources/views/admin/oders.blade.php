@extends('admin.layouts.app')

@section('title', 'Orders')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Orders</h1>
            <p class="text-sm text-slate-500">View orders, assign riders, track delivery status</p>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-2">
            <select name="status"
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                <option value="">All Status</option>
                @foreach(['Pending','Assigned','Picked Up','Delivered','Cancelled'] as $s)
                    <option value="{{ $s }}" @selected(($status ?? '') === $s)>{{ $s }}</option>
                @endforeach
            </select>
            <button class="rounded-xl bg-slate-900 text-white px-4 py-2 text-sm font-semibold hover:opacity-90">
                Filter
            </button>
            <a href="{{ route('admin.orders.index') }}"
               class="rounded-xl bg-slate-100 text-slate-800 px-4 py-2 text-sm font-semibold hover:bg-slate-200">
                Clear
            </a>
        </form>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-rose-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Orders Table --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-slate-600">
                    <th class="px-5 py-3">Order</th>
                    <th class="px-5 py-3">Customer</th>
                    <th class="px-5 py-3">Total</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Rider</th>
                    <th class="px-5 py-3 text-right">Assign Rider</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                @forelse($orders as $order)

                    @php
                        $badge = match ($order->status) {
                            'Pending'   => 'bg-slate-50 text-slate-700 border-slate-200',
                            'Assigned'  => 'bg-amber-50 text-amber-700 border-amber-200',
                            'Picked Up' => 'bg-sky-50 text-sky-700 border-sky-200',
                            'Delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                            default     => 'bg-slate-50 text-slate-700 border-slate-200',
                        };
                    @endphp

                    <tr>
                        <td class="px-5 py-4 font-bold text-slate-900">#{{ $order->id }}</td>

                        <td class="px-5 py-4">
                            <div class="font-semibold text-slate-900">{{ $order->customer->name ?? 'N/A' }}</div>
                            <div class="text-xs text-slate-500">{{ $order->customer->email ?? '' }}</div>
                        </td>

                        <td class="px-5 py-4 text-slate-800">
                            Rs. {{ number_format($order->total, 2) }}
                        </td>

                        <td class="px-5 py-4">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $badge }}">
                                {{ $order->status }}
                            </span>
                            <div class="text-xs text-slate-500 mt-1">
                                @if($order->assigned_at) Assigned: {{ $order->assigned_at->format('Y-m-d h:i A') }} @endif
                                @if($order->picked_up_at) <br>Picked: {{ $order->picked_up_at->format('Y-m-d h:i A') }} @endif
                                @if($order->delivered_at) <br>Delivered: {{ $order->delivered_at->format('Y-m-d h:i A') }} @endif
                            </div>
                        </td>

                        <td class="px-5 py-4">
                            @if($order->rider)
                                <div class="font-semibold text-slate-900">{{ $order->rider->name }}</div>
                                <div class="text-xs text-slate-500">{{ $order->rider->email }}</div>
                            @else
                                <span class="text-xs text-slate-500">Not assigned</span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-right">
                            {{-- Disable assign if delivered/cancelled --}}
                            @if(in_array($order->status, ['Delivered','Cancelled']))
                                <span class="text-xs text-slate-500">Locked</span>
                            @else
                                <form method="POST" action="{{ route('admin.orders.assign', $order) }}" class="flex justify-end gap-2">
                                    @csrf
                                    <select name="rider_id"
                                            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                        <option value="">Select rider</option>
                                        @foreach($riders as $rider)
                                            <option value="{{ $rider->id }}" @selected($order->rider_id == $rider->id)>
                                                {{ $rider->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button class="rounded-xl bg-[#0EA5B9] text-white px-4 py-2 text-sm font-semibold hover:opacity-90">
                                        Assign
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200">
            {{ $orders->links() }}
        </div>
    </div>

</div>

@endsection
