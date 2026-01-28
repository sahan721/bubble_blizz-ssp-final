@extends('rider.layouts.app')

@section('title', 'Earnings')
@section('page_title', 'Earnings')
@section('page_subtitle', 'Track your delivery fees and tips')

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

{{-- Filter + Total --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

    {{-- Filter --}}
    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Filter</h2>
                <p class="text-xs text-slate-500">View earnings by delivered date</p>
            </div>
        </div>

        <form method="GET" action="{{ route('rider.earnings') }}" class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="text-xs font-semibold text-slate-600">From</label>
                <input type="date" name="from" value="{{ $from }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0EA5B9]/40">
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">To</label>
                <input type="date" name="to" value="{{ $to }}"
                       class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0EA5B9]/40">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                        class="w-full rounded-xl bg-[#0EA5B9] text-white px-4 py-2.5 text-sm font-semibold hover:opacity-90">
                    Apply
                </button>

                <a href="{{ route('rider.earnings') }}"
                   class="w-full text-center rounded-xl bg-slate-100 text-slate-800 px-4 py-2.5 text-sm font-semibold hover:bg-slate-200">
                    Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Total Earnings --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
        <div class="text-xs text-slate-500 font-semibold">Total Earnings (Filtered)</div>
        <div class="mt-2 text-3xl font-black text-slate-900">Rs. {{ number_format($totalEarnings, 2) }}</div>
        <div class="mt-3 text-xs text-slate-500">Delivery fees + tips</div>
    </div>
</div>

{{-- Earnings Table --}}
<div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">

    <div class="p-5 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900">Delivered Orders</h2>
            <p class="text-xs text-slate-500">Only orders marked as Delivered</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-slate-600">
                    <th class="px-5 py-3">Order</th>
                    <th class="px-5 py-3">Delivered At</th>
                    <th class="px-5 py-3 text-right">Delivery Fee</th>
                    <th class="px-5 py-3 text-right">Tip</th>
                    <th class="px-5 py-3 text-right">Total</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">
                @forelse($earningsOrders as $order)

                    @php
                        $fee = (float) ($order->delivery_fee ?? 0);
                        $tip = (float) ($order->tip ?? 0);
                        $rowTotal = $fee + $tip;
                    @endphp

                    <tr>
                        <td class="px-5 py-4 font-bold text-slate-900">#{{ $order->id }}</td>

                        <td class="px-5 py-4 text-slate-600">
                            {{ optional($order->delivered_at)->format('Y-m-d h:i A') ?? 'N/A' }}
                        </td>

                        <td class="px-5 py-4 text-right text-slate-700">
                            Rs. {{ number_format($fee, 2) }}
                        </td>

                        <td class="px-5 py-4 text-right text-slate-700">
                            Rs. {{ number_format($tip, 2) }}
                        </td>

                        <td class="px-5 py-4 text-right font-bold text-slate-900">
                            Rs. {{ number_format($rowTotal, 2) }}
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                            No delivered orders found for this period.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-4 border-t border-slate-200">
        {{ $earningsOrders->links() }}
    </div>
</div>

@endsection
