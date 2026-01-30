<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">
@include('customer.partials.topnav')

<main class="mx-auto max-w-7xl px-10 py-10">
    @include('customer.partials.back')

    <h1 class="text-4xl font-extrabold text-[#1f4fbf]">Favorites</h1>

    @if (session('status'))
        <div class="mt-6 rounded-lg bg-green-100 px-4 py-3 text-green-800 font-semibold">
            {{ session('status') }}
        </div>
    @endif

    @if ($products->count() === 0)
        <div class="mt-10 text-gray-500">No favorites yet.</div>
    @else
        <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-4">
            @foreach($products as $p)
                <div class="overflow-hidden rounded-xl bg-white shadow border border-gray-200">
                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-6 flex justify-center">
                        <img
                            src="{{ asset($p->image) ?: asset('images/img_placeholder.png') }}"
                            class="h-32 w-32 object-contain"
                            alt="{{ $p->name }}"

                        >
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-extrabold text-gray-900">{{ $p->name }}</h3>
                        <p class="mt-2 text-gray-500 text-sm">{{ $p->description }}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <div class="text-xl font-extrabold text-[#1f4fbf]">${{ number_format($p->price,2) }}</div>
                            <div class="text-green-700 font-medium text-sm">In Stock ({{ $p->stock }})</div>
                        </div>
                
                        <form method="POST" action="{{ url('/api/customer/favorites/toggle') }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                            <button class="w-full rounded-md bg-red-500 py-3 text-white font-extrabold hover:bg-red-600">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
</body>
</html>
    