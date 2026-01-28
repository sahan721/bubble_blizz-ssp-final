@extends('rider.layouts.app')

@section('title', 'My Orders')
@section('page_title', 'My Orders')
@section('page_subtitle', 'Manage assigned deliveries')

@section('content')

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

<div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">

    <div class="p-5 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900">Assigned Orders</h2>
            <p class="text-xs text-slate-500">Your delivery tasks</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-slate-600">
                    <th class="px-5 py-3">Order</th>
                    <th class="px-5 py-3">Customer</th>
                    <th class="px-5 py-3">Address</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">
                @forelse($orders as $order)

                    @php
                        $badge = match ($order->status) {
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
                            {{ $order->customer->name ?? 'N/A' }}
                        </td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ $order->delivery_address ?? 'N/A' }}
                        </td>

                        <td class="px-5 py-4">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $badge }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-right space-x-2">

                            {{-- Mark Picked Up --}}
                            @if($order->status === 'Assigned')
                                <form method="POST" action="{{ route('rider.orders.picked_up', $order) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="rounded-lg bg-sky-600 text-white px-3 py-1.5 text-xs font-semibold hover:opacity-90">
                                        Picked Up
                                    </button>
                                </form>
                            @endif

                            {{-- Mark Delivered --}}
                            @if($order->status === 'Picked Up')
                                <form method="POST" action="{{ route('rider.orders.delivered', $order) }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="rounded-lg bg-emerald-600 text-white px-3 py-1.5 text-xs font-semibold hover:opacity-90">
                                        Delivered
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                            No orders assigned to you.
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

@endsection
