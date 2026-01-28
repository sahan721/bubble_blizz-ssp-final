<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bubble Blizz - Packages</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50">
@include('customer.partials.topnav')

<main class="mx-auto max-w-7xl px-10 py-10">

    @include('customer.partials.back')
    <h1 class="text-center text-5xl font-extrabold text-[#1f4fbf]">Join Blizz Club</h1>
    <p class="text-center mt-3 text-gray-500 text-lg">Unlock exclusive benefits and premium experiences</p>

    <!-- Plans -->
    <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 max-w-5xl mx-auto">
        <!-- Free -->
        <div class="rounded-xl bg-white shadow border border-gray-200 p-8">
            <h2 class="text-2xl font-extrabold text-gray-900">Free Member</h2>
            <div class="mt-2 text-3xl font-extrabold text-gray-900">$0<span class="text-lg font-medium text-gray-500">/month</span></div>

            <ul class="mt-6 space-y-3 text-gray-700">
                <li class="flex gap-3"><span class="text-gray-400">•</span> Browse all products</li>
                <li class="flex gap-3"><span class="text-gray-400">•</span> Standard delivery</li>
                <li class="flex gap-3"><span class="text-gray-400">•</span> Regular customer support</li>
                <li class="flex gap-3"><span class="text-gray-400">•</span> Order tracking</li>
            </ul>

            <div class="mt-10 text-center text-gray-400">Current Plan</div>
        </div>

        <!-- Premium -->
        <div class="rounded-xl bg-gradient-to-b from-[#1f4fbf] to-[#1a43a6] shadow border border-gray-200 p-8 text-white relative">
            <div class="absolute right-6 top-6 rounded-full bg-yellow-400 px-3 py-1 text-xs font-extrabold text-yellow-900">
                PREMIUM
            </div>

            <h2 class="text-2xl font-extrabold">Blizz Club Premium</h2>
            <div class="mt-2 text-4xl font-extrabold">$9.99<span class="text-lg font-medium text-white/80">/month</span></div>

            <ul class="mt-6 space-y-3">
                @php
                  $perks = [
                    'Free delivery on all orders',
                    '15% discount on all beverages',
                    'Priority delivery (30 mins or less)',
                    'Exclusive products access',
                    '24/7 premium support',
                    'Early access to new flavors',
                    'Exclusive events invitations',
                    'Monthly free drink voucher',
                  ];
                @endphp
                @foreach($perks as $perk)
                    <li class="flex gap-3">
                        <span class="mt-2 h-2 w-2 rounded-full bg-yellow-400"></span>
                        <span class="font-semibold">{{ $perk }}</span>
                    </li>
                @endforeach
            </ul>

            <button class="mt-8 w-full rounded-md bg-yellow-400 py-3 font-extrabold text-yellow-900 hover:bg-yellow-300">
                Upgrade to Premium
            </button>
        </div>
    </div>

    <!-- Why choose -->
    <div class="mt-14 max-w-5xl mx-auto rounded-xl bg-white shadow border border-gray-200 p-10">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">Why Choose Blizz Club Premium?</h2>

        <div class="mt-10 grid grid-cols-1 gap-10 md:grid-cols-3 text-center">
            <div>
                <div class="mx-auto h-16 w-16 rounded-full bg-[#1f4fbf] flex items-center justify-center text-2xl">🚚</div>
                <div class="mt-4 font-extrabold text-gray-900">Free Fast Delivery</div>
                <div class="mt-2 text-gray-500">Get your favorite drinks delivered within 30 minutes, absolutely free!</div>
            </div>

            <div>
                <div class="mx-auto h-16 w-16 rounded-full bg-[#1f4fbf] flex items-center justify-center text-2xl">💰</div>
                <div class="mt-4 font-extrabold text-gray-900">Exclusive Savings</div>
                <div class="mt-2 text-gray-500">Save 15% on every order plus get special member-only discounts.</div>
            </div>

            <div>
                <div class="mx-auto h-16 w-16 rounded-full bg-[#1f4fbf] flex items-center justify-center text-2xl">⭐</div>
                <div class="mt-4 font-extrabold text-gray-900">Premium Perks</div>
                <div class="mt-2 text-gray-500">Access exclusive flavors, events, and priority customer support.</div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
