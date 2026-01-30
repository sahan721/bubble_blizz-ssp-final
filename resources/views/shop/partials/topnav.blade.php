<nav class="bg-white shadow-sm border-b">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('shop.home') }}" class="text-2xl font-bold text-indigo-600">
                    Bubble Blizz
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('shop.home') }}" 
                   class="text-gray-700 hover:text-indigo-600 {{ request()->routeIs('shop.home') ? 'text-indigo-600 font-semibold' : '' }}">
                    Home
                </a>
                <a href="{{ route('shop.products') }}" 
                   class="text-gray-700 hover:text-indigo-600 {{ request()->routeIs('shop.products') ? 'text-indigo-600 font-semibold' : '' }}">
                    Products
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('customer.home') }}" 
                       class="text-indigo-600 hover:text-indigo-800 font-medium">
                        My Account
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-indigo-600">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>