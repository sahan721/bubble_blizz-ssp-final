@extends('rider.layouts.app')

@section('title', 'My Orders')

    @section('content')
        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">My Orders</h1>
                <p class="text-slate-600 mt-1">Orders assigned to you. Update status as you deliver.</p>
            </div>
            <a href="{{ route('rider.dashboard') }}"
            class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50">
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($orders as $order)
                        @php
                            $badge = match($order->status) {
                                'Pending'   => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                                'Assigned'  => ['bg' => 'bg-blue-100',   'text' => 'text-blue-800'],
                                'Picked Up' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-800'],
                                'Delivered' => ['bg' => 'bg-green-100',  'text' => 'text-green-800'],
                                'Cancelled' => ['bg' => 'bg-red-100',    'text' => 'text-red-800'],
                                default     => ['bg' => 'bg-slate-100',  'text' => 'text-slate-800'],
                            };
                        @endphp

                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">
                                #{{ $order->id }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                {{ $order->customer->name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge['bg'] }} {{ $badge['text'] }}">
                                    {{ $order->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                LKR {{ number_format($order->total ?? 0, 2) }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ optional($order->created_at)->format('Y-m-d H:i') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end gap-2">

                                    {{-- ✅ Accept: Pending -> Assigned --}}
                                    @if($order->status === 'Pending')
                                        <form method="POST" action="{{ route('rider.orders.accept', $order) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="px-3 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
                                                Accept
                                            </button>
                                        </form>
                                    @endif

                                    {{-- ✅ Pick Up: Assigned -> Picked Up --}}
                                    @if($order->status === 'Assigned')
                                        <form method="POST" action="{{ route('rider.orders.pickup', $order) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="px-3 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                                                Pick Up
                                            </button>
                                        </form>
                                    @endif

                                    {{-- ✅ Deliver: Picked Up -> Delivered --}}
                                    @if($order->status === 'Picked Up')
                                        <form method="POST" action="{{ route('rider.orders.deliver', $order) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="px-3 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                                                Deliver
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($orders, 'links'))
                <div class="px-6 py-4 border-t border-slate-200 bg-white">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    @endsection
