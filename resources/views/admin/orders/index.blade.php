@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Manage Orders</h1>
            <p class="text-sm text-slate-500 mt-1">Track orders, update status, and assign riders.</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-5">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row gap-3">
            <select name="status"
                    class="w-full sm:w-60 rounded-xl border-slate-200 focus:border-slate-400 focus:ring-slate-200">
                <option value="">All Statuses</option>
                @foreach($statuses as $s)
                    <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button class="rounded-xl px-4 py-2 text-sm font-semibold bg-slate-900 text-white hover:bg-slate-800">
                    Filter
                </button>
                <a href="{{ route('admin.orders.index') }}"
                   class="rounded-xl px-4 py-2 text-sm font-semibold bg-slate-50 hover:bg-slate-100 ring-1 ring-slate-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="p-5 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-xs uppercase text-slate-500">
                    <tr>
                        <th class="text-left py-3 pr-4">Order</th>
                        <th class="text-left py-3 pr-4">Customer</th>
                        <th class="text-left py-3 pr-4">Rider</th>
                        <th class="text-left py-3 pr-4">Status</th>
                        <th class="text-left py-3 pr-4">Total</th>
                        <th class="text-right py-3">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                @forelse($orders as $o)
                    <tr class="text-slate-700">
                        <td class="py-3 pr-4 font-medium text-slate-900">#{{ $o->id }}</td>
                        <td class="py-3 pr-4">{{ $o->user->name ?? '—' }}</td>
                        <td class="py-3 pr-4">{{ $o->rider->name ?? 'Not assigned' }}</td>
                        <td class="py-3 pr-4">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ $o->status === 'Delivered' ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : '' }}
                                {{ $o->status === 'Pending' ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' : '' }}
                                {{ $o->status === 'Processing' ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200' : '' }}
                                {{ $o->status === 'Cancelled' ? 'bg-rose-50 text-rose-700 ring-1 ring-rose-200' : '' }}
                            ">
                                {{ $o->status }}
                            </span>
                        </td>
                        <td class="py-3 pr-4">LKR {{ number_format((float)$o->total, 2) }}</td>
                        <td class="py-3 text-right">
                            <a href="{{ route('admin.orders.show', $o->id) }}"
                               class="rounded-xl px-3 py-2 text-xs font-semibold bg-slate-50 hover:bg-slate-100 ring-1 ring-slate-200">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">No orders found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t">
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection