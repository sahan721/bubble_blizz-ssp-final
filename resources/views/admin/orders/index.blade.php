@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
<div class="max-w-7xl mx-auto">

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

    {{-- Header + Shop Tabs --}}
    <div class="flex flex-col gap-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Orders</h1>
                <p class="text-sm text-slate-500">Shop view: Pending first, assign riders quickly</p>
            </div>

            <a href="{{ route('admin.orders.index') }}"
               class="rounded-xl bg-slate-100 text-slate-800 px-4 py-2 text-sm font-semibold hover:bg-slate-200">
                Refresh
            </a>
        </div>

        @php
            $tabs = [
                '' => 'All',
                'Pending' => 'Pending',
                'Assigned' => 'Assigned',
                'Picked Up' => 'Picked Up',
                'Delivered' => 'Delivered',
                'Cancelled' => 'Cancelled',
            ];
            $active = $status ?? '';
        @endphp

        <div class="flex flex-wrap gap-2">
            @foreach($tabs as $key => $label)
                <a href="{{ route('admin.orders.index', $key ? ['status' => $key] : []) }}"
                   class="px-4 py-2 rounded-xl text-sm font-bold border transition
                   {{ $active === $key
                        ? 'bg-[#0EA5B9] text-white border-[#0EA5B9]'
                        : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Orders table --}}
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
                    <th class="px-5 py-3 text-right">Assign</th>
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
                        <td class="px-5 py-4 font-bold text-slate-900">
                            #{{ $order->id }}
                            <div class="text-xs text-slate-500 font-normal">
                                {{ optional($order->created_at)->format('d M Y, h:i A') }}
                            </div>
                        </td>

                        <td class="px-5 py-4">
                            <div class="font-semibold text-slate-900">{{ $order->customer->name ?? 'N/A' }}</div>
                            <div class="text-xs text-slate-500">{{ $order->customer->email ?? '' }}</div>
                        </td>

                        <td class="px-5 py-4 text-slate-800 font-semibold">
                            Rs. {{ number_format($order->total, 2) }}
                        </td>

                        <td class="px-5 py-4">
                            <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $badge }}">
                                {{ $order->status }}
                            </span>

                            {{-- Optional timestamps (looks pro) --}}
                            <div class="mt-2 text-xs text-slate-500 space-y-1">
                                @if($order->assigned_at) <div>Assigned: {{ $order->assigned_at->format('d M, h:i A') }}</div> @endif
                                @if($order->picked_up_at) <div>Picked Up: {{ $order->picked_up_at->format('d M, h:i A') }}</div> @endif
                                @if($order->delivered_at) <div>Delivered: {{ $order->delivered_at->format('d M, h:i A') }}</div> @endif
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
                            @if(in_array($order->status, ['Delivered','Cancelled'], true))
                                <span class="text-xs text-slate-500">Locked</span>
                            @else
                                <form method="POST" action="{{ route('admin.orders.assign', $order) }}" class="flex justify-end gap-2">
                                    @csrf
                                    <select name="rider_id"
                                            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm"
                                            required>
                                        <option value="">Select rider</option>
                                        @foreach($riders as $r)
                                            <option value="{{ $r->id }}" @selected($order->rider_id == $r->id)>
                                                {{ $r->name }}
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
