<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bubble Blizz - Orders</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">

@include('customer.partials.topnav')

<main class="mx-auto max-w-7xl px-10 py-10">

    @include('customer.partials.back')

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-[#1f4fbf]">My Orders</h1>

        <a href="{{ url('/products') }}"
           class="rounded-md bg-[#2e6bd3] px-7 py-3 text-white font-semibold shadow hover:bg-[#255fc1]">
            Continue Shopping
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mt-6 mx-auto max-w-4xl rounded-lg bg-green-100 px-4 py-3 text-green-800 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mt-6 mx-auto max-w-4xl rounded-lg bg-red-100 px-4 py-3 text-red-800 font-semibold">
            {{ session('error') }}
        </div>
    @endif

    {{-- Orders --}}
    <div class="mt-10 space-y-6 max-w-4xl">

        @forelse($orders as $order)

            @php
                $status = $order->status ?? 'Pending';

                $statusClass = match ($status) {
                    'Pending'   => 'bg-yellow-200 text-yellow-900',
                    'Assigned'  => 'bg-amber-200 text-amber-900',
                    'Picked Up' => 'bg-sky-200 text-sky-900',
                    'Delivered' => 'bg-green-200 text-green-900',
                    'Cancelled' => 'bg-red-200 text-red-900',
                    default     => 'bg-gray-200 text-gray-900',
                };
            @endphp

            <div class="rounded-xl bg-white shadow border border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xl font-extrabold text-gray-900">
                            Order #{{ $order->id }}
                        </div>

                        <div class="text-gray-500">
                            {{ optional($order->created_at)->format('M d, Y h:i A') }}
                        </div>

                        <div class="mt-2 text-gray-500">
                            Payment: <span class="font-semibold text-gray-700">{{ $order->payment_method ?? 'N/A' }}</span>
                        </div>

                        <div class="mt-1 text-gray-500">
                            Address: <span class="font-semibold text-gray-700">{{ $order->delivery_address ?? 'N/A' }}</span>
                        </div>

                        {{-- Rider info (when assigned) --}}
                        @if($order->rider)
                            <div class="mt-3 text-gray-600">
                                Rider: <span class="font-bold text-gray-800">{{ $order->rider->name }}</span>
                                <span class="text-gray-500">({{ $order->rider->email }})</span>
                            </div>
                        @endif
                    </div>

                    <div class="text-right">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-bold {{ $statusClass }}">
                            {{ $status }}
                        </span>

                        <div class="mt-3 text-lg font-extrabold text-gray-900">
                            ${{ number_format((float)$order->total, 2) }}
                        </div>

                        {{-- Timeline (optional, looks professional) --}}
                        <div class="mt-3 text-xs text-gray-500 space-y-1">
                            @if($order->assigned_at) <div>Assigned: {{ $order->assigned_at->format('M d, h:i A') }}</div> @endif
                            @if($order->picked_up_at) <div>Picked Up: {{ $order->picked_up_at->format('M d, h:i A') }}</div> @endif
                            @if($order->delivered_at) <div>Delivered: {{ $order->delivered_at->format('M d, h:i A') }}</div> @endif
                        </div>
                    </div>
                </div>

                {{-- Optional actions --}}
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ url('/products') }}"
                       class="rounded-md bg-[#1f4fbf] px-6 py-2 text-white font-semibold hover:bg-[#1a43a6]">
                        Order Again
                    </a>

                    @if(($order->status ?? '') === 'Pending')
                        <span class="text-sm text-gray-500">
                            Waiting for admin to assign a rider...
                        </span>
                    @endif
                </div>
            </div>

        @empty
            <div class="rounded-xl bg-white shadow border border-gray-200 p-10 text-center text-gray-500">
                You have no orders yet.
            </div>
        @endforelse

    </div>
</main>
</body>
</html>
