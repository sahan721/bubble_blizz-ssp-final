<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- ✅ REQUIRED because this page is not using Jetstream layout --}}
    @livewireStyles
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

@include('customer.partials.topnav')

<!-- Hero/Header Section -->
<div class="relative overflow-hidden bg-gradient-to-r from-[#1f4fbf] to-[#2d5bc7] text-white py-12 px-6">
    <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('images/img_banner.png') }}');"></div>
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 animate-fade-in">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-3">Our Products</h1>
                <p class="text-lg md:text-xl opacity-90 max-w-2xl">
                    Discover our premium collection of beverages. Fresh, delicious, and delivered to your doorstep.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">

                <a href="{{ route('customer.cart') }}"
                   class="rounded-lg bg-white text-[#1f4fbf] px-6 py-3 font-bold hover:bg-gray-100 transition-all hover:shadow-xl hover:-translate-y-0.5">
                    View Cart
                </a>
            </div>
        </div>
    </div>
</div>

<main class="max-w-7xl mx-auto px-6 py-10">

    @include('customer.partials.back')

    @php
        $favoriteIds = $favoriteIds ?? [];
    @endphp

    <!-- Category Navigation Chips -->
    <div class="sticky top-20 z-40 bg-white/80 backdrop-blur-sm border-b border-gray-200 py-4 -mx-6 px-6 mb-8 shadow-sm">
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="#juices"
               class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border-2 border-[#1f4fbf] text-[#1f4fbf] font-semibold text-sm transition-all hover:bg-[#1f4fbf] hover:text-white hover:shadow-lg hover:-translate-y-0.5 smooth-scroll">
                <img src="{{ asset('images/img_fruitjuice.png') }}" alt="Fruit Juice" class="w-5 h-5 object-contain">
                Fruit Juices
            </a>
            <a href="#soft-drinks"
               class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border-2 border-[#1f4fbf] text-[#1f4fbf] font-semibold text-sm transition-all hover:bg-[#1f4fbf] hover:text-white hover:shadow-lg hover:-translate-y-0.5 smooth-scroll">
                <img src="{{ asset('images/img_softdrink.png') }}" alt="Soft Drink" class="w-5 h-5 object-contain">
                Soft Drinks
            </a>
            <a href="#dairy"
               class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border-2 border-[#1f4fbf] text-[#1f4fbf] font-semibold text-sm transition-all hover:bg-[#1f4fbf] hover:text-white hover:shadow-lg hover:-translate-y-0.5 smooth-scroll">
                <img src="{{ asset('images/img_dairydrink.png') }}" alt="Dairy Drink" class="w-5 h-5 object-contain">
                Dairy Drinks
            </a>
            <a href="#energy-drinks"
               class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border-2 border-[#1f4fbf] text-[#1f4fbf] font-semibold text-sm transition-all hover:bg-[#1f4fbf] hover:text-white hover:shadow-lg hover:-translate-y-0.5 smooth-scroll">
                <img src="{{ asset('images/img_energydrink.png') }}" alt="Energy Drink" class="w-5 h-5 object-contain">
                Energy Drinks
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="mt-6 rounded-xl bg-gradient-to-r from-green-100 to-emerald-50 border border-green-200 px-6 py-4 text-green-800 font-semibold shadow-sm animate-pulse">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('status') }}
            </div>
        </div>
    @endif

    {{-- ✅ Livewire: this is the actual “external library usage” feature --}}
    <livewire:product-browser
        :juices="$juices"
        :softDrinks="$softDrinks"
        :dairy="$dairy"
        :energyDrinks="$energyDrinks"
        :favoriteIds="$favoriteIds"
    />

</main>

<!-- Back to Top Button -->
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        id="backToTop"
        class="fixed bottom-8 right-8 hidden md:flex items-center gap-2 rounded-full bg-[#1f4fbf] text-white px-5 py-3 font-semibold shadow-xl hover:bg-[#173c92] hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 z-50">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
    </svg>
    Top
</button>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes cardEnter {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in { animation: fadeIn 0.6s ease-out; }
.animate-card-enter { animation: cardEnter 0.5s ease-out forwards; }

.grid > div:nth-child(1) { animation-delay: 0.1s; }
.grid > div:nth-child(2) { animation-delay: 0.2s; }
.grid > div:nth-child(3) { animation-delay: 0.3s; }
.grid > div:nth-child(4) { animation-delay: 0.4s; }

.smooth-scroll { scroll-behavior: smooth; }

#backToTop {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
}
#backToTop.visible {
    opacity: 1;
    transform: translateY(0);
}

button:focus-visible, a:focus-visible, select:focus-visible {
    outline: 2px solid #1f4fbf;
    outline-offset: 2px;
}

@media (max-width: 768px) {
    .animate-card-enter { animation: none; }
}
</style>

<script>
window.addEventListener('scroll', function() {
    const backToTopBtn = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTopBtn.classList.add('visible');
        backToTopBtn.classList.remove('hidden');
    } else {
        backToTopBtn.classList.remove('visible');
        backToTopBtn.classList.add('hidden');
    }
});

document.querySelectorAll('.smooth-scroll').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>

{{-- ✅ REQUIRED because this page is not using Jetstream layout --}}
@livewireScripts
</body>
</html>
