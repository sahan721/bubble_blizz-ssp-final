<header class="sticky top-0 z-50 bg-[#1f4fbf] text-white shadow-lg backdrop-blur-sm" x-data="{ mobileMenuOpen: false }">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex h-16 items-center justify-between">

            <!-- Back Button & Brand -->
            <div class="flex items-center gap-3">
                <button onclick="history.back()" 
                        class="md:hidden rounded-lg bg-white/20 p-2 hover:bg-white/30 transition-colors focus:outline-none focus:ring-2 focus:ring-white/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <a href="{{ url('/customer/home') }}" class="flex items-center gap-2 hover:opacity-95 transition-opacity">
                    <img src="{{ asset('images/bubbleblizz-logo.png') }}" alt="Bubble Blizz Logo" class="h-8 w-8 object-contain">
                    <span class="text-2xl font-extrabold tracking-wide">Bubble Blizz</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold">
                @php $currentRoute = Route::currentRouteName(); @endphp
                <a href="{{ route('customer.home') }}" 
                   class="hover:opacity-90 transition-opacity {{ $currentRoute === 'customer.home' ? 'underline underline-offset-4' : '' }}">Home</a>
                <a href="{{ route('customer.products') }}" 
                   class="hover:opacity-90 transition-opacity {{ $currentRoute === 'customer.products' ? 'underline underline-offset-4' : '' }}">Products</a>
                <a href="{{ route('customer.favorites') }}" 
                   class="hover:opacity-90 transition-opacity {{ $currentRoute === 'customer.favorites' ? 'underline underline-offset-4' : '' }}">Favorites</a>
                <a href="{{ route('customer.cart') }}" 
                   class="hover:opacity-90 transition-opacity {{ $currentRoute === 'customer.cart' ? 'underline underline-offset-4' : '' }}">Cart</a>
                <a href="{{ route('customer.orders') }}" 
                   class="hover:opacity-90 transition-opacity {{ $currentRoute === 'customer.orders' ? 'underline underline-offset-4' : '' }}">Orders</a>
                <a href="{{ route('customer.packages') }}" 
                   class="hover:opacity-90 transition-opacity {{ $currentRoute === 'customer.packages' ? 'underline underline-offset-4' : '' }}">Packages</a>
                <a href="{{ route('settings.index') }}" 
                   class="hover:opacity-90 transition-opacity {{ $currentRoute === 'settings.index' ? 'underline underline-offset-4' : '' }}">Settings</a>
            </nav>

            <!-- Right Section -->
            <div class="flex items-center gap-4">
                <!-- User Info -->
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white/20 text-sm font-bold transition-all hover:bg-white/30">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <span class="hidden sm:inline text-sm opacity-95">{{ auth()->user()->name ?? 'user' }}</span>
                </div>

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden rounded-lg bg-white/20 p-2 hover:bg-white/30 transition-colors focus:outline-none focus:ring-2 focus:ring-white/50">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="hidden md:block rounded-lg bg-white/20 px-4 py-2 text-sm font-semibold hover:bg-white/30 transition-all hover:shadow-lg">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <nav x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden pb-4 mt-2 space-y-2">
            
            <div class="space-y-2 pt-2 border-t border-white/20">
                <a href="{{ route('customer.home') }}" 
                   @click="mobileMenuOpen = false"
                   class="block rounded-lg bg-white/15 px-4 py-3 text-sm font-medium hover:bg-white/25 transition-all">Home</a>
                <a href="{{ route('customer.products') }}" 
                   @click="mobileMenuOpen = false"
                   class="block rounded-lg bg-white/15 px-4 py-3 text-sm font-medium hover:bg-white/25 transition-all">Products</a>
                <a href="{{ route('customer.favorites') }}" 
                   @click="mobileMenuOpen = false"
                   class="block rounded-lg bg-white/15 px-4 py-3 text-sm font-medium hover:bg-white/25 transition-all">Favorites</a>
                <a href="{{ route('customer.cart') }}" 
                   @click="mobileMenuOpen = false"
                   class="block rounded-lg bg-white/15 px-4 py-3 text-sm font-medium hover:bg-white/25 transition-all">Cart</a>
                <a href="{{ route('customer.orders') }}" 
                   @click="mobileMenuOpen = false"
                   class="block rounded-lg bg-white/15 px-4 py-3 text-sm font-medium hover:bg-white/25 transition-all">Orders</a>
                <a href="{{ route('customer.packages') }}" 
                   @click="mobileMenuOpen = false"
                   class="block rounded-lg bg-white/15 px-4 py-3 text-sm font-medium hover:bg-white/25 transition-all">Packages</a>
                <a href="{{ route('settings.index') }}" 
                   @click="mobileMenuOpen = false"
                   class="block rounded-lg bg-white/15 px-4 py-3 text-sm font-medium hover:bg-white/25 transition-all">Settings</a>
                
                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-white/20">
                    @csrf
                    <button class="w-full text-left rounded-lg bg-white/15 px-4 py-3 text-sm font-medium hover:bg-white/25 transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </div>
</header>
