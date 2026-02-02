@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Order #{{ $order->id }}</h1>
            <p class="text-sm text-slate-500 mt-1">
                Customer: <span class="font-medium text-slate-800">{{ $order->customer->name ?? '—' }}</span>
                • {{ $order->created_at?->format('Y-m-d H:i') }}
            </p>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="rounded-xl px-4 py-2 text-sm font-semibold bg-slate-50 hover:bg-slate-100 ring-1 ring-slate-200">
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Order Items --}}
        <div class="lg:col-span-2 rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="p-5 border-b">
                <h2 class="text-sm font-semibold text-slate-900">Order Items</h2>
            </div>

            <div class="p-5 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-xs uppercase text-slate-500">
                        <tr>
                            <th class="text-left py-3 pr-4">Product</th>
                            <th class="text-left py-3 pr-4">Qty</th>
                            <th class="text-left py-3 pr-4">Price</th>
                            <th class="text-right py-3">Line Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                    @forelse($order->items as $it)
                        @php
                            $p = $it->product;
                            $qty = (int)($it->qty ?? $it->quantity ?? 1);
                            $price = (float)($it->price ?? $p?->price ?? 0);
                            $line = $qty * $price;
                        @endphp
                        <tr class="text-slate-700">
                            <td class="py-3 pr-4 font-medium text-slate-900">{{ $p->name ?? '—' }}</td>
                            <td class="py-3 pr-4">{{ $qty }}</td>
                            <td class="py-3 pr-4">LKR {{ number_format($price, 2) }}</td>
                            <td class="py-3 text-right">LKR {{ number_format($line, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-500">No items found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 border-t flex justify-end">
                <div class="text-right">
                    <div class="text-xs text-slate-500">Total</div>
                    <div class="text-xl font-semibold text-slate-900">LKR {{ number_format((float)$order->total, 2) }}</div>
                </div>
            </div>
        </div>

        {{-- Update Panel --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="p-5 border-b">
                <h2 class="text-sm font-semibold text-slate-900">Update Order</h2>
                <p class="text-xs text-slate-500 mt-1">Change status and assign a rider.</p>
            </div>

            <div class="p-5 space-y-4">
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-sm font-medium text-slate-700">Status</label>
                        <select name="status"
                                class="mt-2 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                            @foreach($statuses as $s)
                                <option value="{{ $s }}" {{ old('status', $order->status) === $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700">Assign Rider</label>
                        <select name="rider_id"
                                class="mt-2 w-full rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                            <option value="">Not assigned</option>
                            @foreach($riders as $r)
                                <option value="{{ $r->id }}" {{ (string)old('rider_id', $order->rider_id) === (string)$r->id ? 'selected' : '' }}>
                                    {{ $r->name }} ({{ $r->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="w-full rounded-xl px-5 py-2.5 text-sm font-semibold bg-slate-900 text-white hover:bg-slate-800">
                        Save Changes
                    </button>
                </form>

                <div class="rounded-xl bg-slate-50 p-4 ring-1 ring-slate-200">
                    <div class="text-xs text-slate-500">Current Rider</div>
                    <div class="text-sm font-semibold text-slate-900 mt-1">
                        {{ $order->rider->name ?? 'Not assigned' }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection