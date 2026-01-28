@extends('rider.layouts.app')

@section('title', 'Delivered History')
@section('page_title', 'Delivered History')
@section('page_subtitle', 'Completed deliveries (read-only)')

@section('content')
<div class="max-w-6xl fade-up">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Delivered History</h1>
            <p class="text-sm text-slate-500">Your completed deliveries</p>
        </div>

        <a href="{{ route('rider.orders') }}"
           class="rounded-xl bg-slate-100 text-slate-700 px-4 py-2 text-sm font-semibold hover:bg-slate-200 transition">
            Back to Active Orders
        </a>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-slate-600">
                    <th class="px-5 py-3">Order</th>
                    <th class="px-5 py-3">Customer</th>
                    <th class="px-5 py-3">Total</th>
                    <th class="px-5 py-3">Delivered At</th>
                    <th class="px-5 py-3">Payment</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-5 py-4 font-bold text-slate-900">#{{ $order->id }}</td>

                        <td class="px-5 py-4">
                            <div class="font-semibold text-slate-900">{{ $order->customer->name ?? 'N/A' }}</div>
                            <div class="text-xs text-slate-500">{{ $order->customer->email ?? '' }}</div>
                        </td>

                        <td class="px-5 py-4 text-slate-800 font-semibold">
                            Rs. {{ number_format($order->total, 2) }}
                        </td>

                        <td class="px-5 py-4 text-slate-700">
                            {{ $order->delivered_at ? $order->delivered_at->format('d M Y, h:i A') : '—' }}
                        </td>

                        <td class="px-5 py-4 text-slate-700">
                            {{ $order->payment_method ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                            No delivered orders yet.
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
