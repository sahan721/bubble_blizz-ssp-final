<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bubble Blizz - Cart</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">
@include('customer.partials.topnav')

<main class="mx-auto max-w-7xl px-10 py-10">
    @include('customer.partials.back')

    <h1 class="text-center text-4xl font-extrabold text-[#1f4fbf]">Shopping Cart</h1>

    {{-- Existing status message --}}
    @if (session('status'))
        <div class="mt-6 mx-auto max-w-4xl rounded-lg bg-green-100 px-4 py-3 text-green-800 font-semibold">
            {{ session('status') }}
        </div>
    @endif

    {{-- NEW: success message (used by order place redirect if you want) --}}
    @if (session('success'))
        <div class="mt-6 mx-auto max-w-4xl rounded-lg bg-green-100 px-4 py-3 text-green-800 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    {{-- NEW: error message --}}
    @if (session('error'))
        <div class="mt-6 mx-auto max-w-4xl rounded-lg bg-red-100 px-4 py-3 text-red-800 font-semibold">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mt-6 mx-auto max-w-4xl rounded-lg bg-red-100 px-4 py-3 text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Cart box -->
    <div class="mx-auto mt-8 max-w-4xl rounded-xl bg-white shadow border border-gray-200">
        <div class="p-6">

            @if (count($items) === 0)
                <div class="py-12 text-center text-gray-500">
                    Your cart is empty.
                    <div class="mt-4">
                        <a href="{{ url('/products') }}"
                           class="inline-block rounded-md bg-[#2e6bd3] px-7 py-3 text-white font-semibold shadow hover:bg-[#255fc1]">
                            Go to Products
                        </a>
                    </div>
                </div>
            @else

                @foreach($items as $i)
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between py-5 {{ !$loop->last ? 'border-b' : '' }}">

                        <!-- Left -->
                        <div class="flex items-center gap-5">
                            <div class="h-20 w-20 rounded bg-gray-200 flex items-center justify-center">
                                <img 
                                    src="{{ asset($i['image']) ?: asset('images/img_placeholder.png') }}" 
                                    class="h-16 w-16 object-contain"
                                    alt="{{ $i['name'] }}"

                                >
                            </div>
                        
                            <div>
                                <div class="text-xl font-extrabold text-gray-900">{{ $i['name'] }}</div>
                                <div class="text-gray-500 text-sm">{{ $i['desc'] }}</div>
                                <div class="text-[#1f4fbf] font-extrabold">${{ number_format($i['price'],2) }} each</div>
                            </div>
                        </div>

                        <!-- Right -->
                        <div class="mt-4 md:mt-0 flex items-center gap-10">

                            <!-- Qty controls -->
                            <div class="flex items-center gap-3 text-xl text-gray-700">
                                <!-- minus -->
                                <form method="POST" action="{{ route('customer.cart.update') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $i['id'] }}">
                                    <input type="hidden" name="qty" value="{{ $i['qty'] - 1 }}">
                                    <button class="h-10 w-10 rounded border bg-white hover:bg-gray-100">-</button>
                                </form>

                                <div class="h-10 w-12 rounded border flex items-center justify-center font-bold">
                                    {{ $i['qty'] }}
                                </div>

                                <!-- plus -->
                                <form method="POST" action="{{ route('customer.cart.update') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $i['id'] }}">
                                    <input type="hidden" name="qty" value="{{ $i['qty'] + 1 }}">
                                    <button class="h-10 w-10 rounded border bg-white hover:bg-gray-100">+</button>
                                </form>
                            </div>

                            <!-- Line + remove -->
                            <div class="text-right">
                                <div class="text-xl font-extrabold">${{ number_format($i['line'],2) }}</div>

                                <form method="POST" action="{{ route('customer.cart.remove') }}" class="mt-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $i['id'] }}">
                                    <button class="text-red-500 font-semibold hover:underline">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Total + actions -->
                <div class="border-t pt-6 mt-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="text-2xl font-extrabold text-gray-900">
                            Total: ${{ number_format($total,2) }}
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ url('/products') }}"
                               class="rounded-md bg-gray-600 px-6 py-3 text-white font-semibold hover:bg-gray-700">
                                Continue Shopping
                            </a>

                            <form method="POST" action="{{ route('customer.cart.clear') }}">
                                @csrf
                                <button class="rounded-md bg-red-600 px-6 py-3 text-white font-semibold hover:bg-red-700">
                                    Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>

    <!-- Checkout section -->
    @if (count($items) > 0)
        <div class="mx-auto mt-10 max-w-4xl rounded-xl bg-white shadow border border-gray-200">
            <div class="p-8">
                <h2 class="text-2xl font-extrabold text-gray-900">Checkout</h2>

                {{-- IMPORTANT: Wrap checkout in a form that posts to place_order --}}
                <form method="POST" action="{{ route('customer.orders.store') }}">
                    @csrf

                    <div class="mt-5">
                        <label class="block font-bold text-gray-700">Delivery Address</label>
                        <textarea name="address"
                                  class="mt-2 w-full rounded-md border-gray-300"
                                  rows="4"
                                  placeholder="Enter your delivery address"
                                  required>{{ old('address') }}</textarea>
                    </div>

                    <div class="mt-5">
                        <label class="block font-bold text-gray-700">Payment Method</label>
                        <select name="payment_method" class="mt-2 w-full rounded-md border-gray-300" required>
                            <option value="" selected>Select Payment Method</option>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                            <option value="Card Payment">Card Payment</option>
                        </select>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-4">
                        <a href="{{ url('/products') }}"
                           class="w-40 rounded-md bg-gray-600 py-3 text-center text-white hover:bg-gray-700">
                            Cancel
                        </a>

                        <button type="submit"
                                class="w-60 rounded-md bg-[#2e6bd3] py-3 text-white font-semibold hover:bg-[#255fc1]">
                            Place Order (${{ number_format($total,2) }})
                        </button>
                    </div>

                    <p class="text-xs text-gray-500 mt-3">
                        After placing, your order will be <b>Pending</b> until an admin assigns a rider.
                    </p>
                </form>

            </div>
        </div>
    @endif
</main>
</body>
</html>
