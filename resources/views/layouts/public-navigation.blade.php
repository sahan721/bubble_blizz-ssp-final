<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('shop.home') }}" class="text-xl font-bold text-[#1f4fbf]">
                        DrinkShop
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ route('shop.home') }}" 
                       class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('shop.index') }}" 
                       class="{{ request()->routeIs('shop.index') ? 'border-[#1f4fbf] text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Shop
                    </a>
                </div>
            </div>
            
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <!-- Authenticated user menu -->
                    <div class="ml-3 relative">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('cart') }}" class="text-gray-500 hover:text-gray-700 relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v5m-5 0h5"></path>
                                </svg>
                                @if(session('cart') && count(session('cart')) > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ array_sum(session('cart')) }}
                                    </span>
                                @endif
                            </a>
                            
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        @if (Auth::user()->profile_photo_path)
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-600 text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </button>
                                </x-slot>
                                
                                <x-slot name="content">
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Account') }}
                                    </div>
                                    
                                    <x-dropdown-link href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                    
                                    @if(Auth::user()->hasRole('customer'))
                                        <x-dropdown-link href="{{ route('customer.orders.index') }}">
                                            {{ __('My Orders') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('customer.favorites.index') }}">
                                            {{ __('Favorites') }}
                                        </x-dropdown-link>
                                    @endif
                                    
                                    @if(Auth::user()->hasRole('admin'))
                                        <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                            {{ __('Admin Dashboard') }}
                                        </x-dropdown-link>
                                    @endif
                                    
                                    @if(Auth::user()->hasRole('rider'))
                                        <x-dropdown-link href="{{ route('rider.home') }}">
                                            {{ __('Rider Dashboard') }}
                                        </x-dropdown-link>
                                    @endif
                                    
                                    <div class="border-t border-gray-200"></div>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                @else
                    <!-- Guest menu -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="bg-[#1f4fbf] hover:bg-[#173c92] text-white px-4 py-2 rounded-md text-sm font-medium">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
            
            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#1f4fbf]">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu -->
    <div class="sm:hidden hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('shop.home') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Home
            </a>
            <a href="{{ route('shop.index') }}" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Shop
            </a>
        </div>
        
        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        @if (Auth::user()->profile_photo_path)
                            <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-600 text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        {{ __('Profile') }}
                    </a>
                    
                    @if(Auth::user()->hasRole('customer'))
                        <a href="{{ route('customer.orders.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            {{ __('My Orders') }}
                        </a>
                        <a href="{{ route('customer.favorites.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            {{ __('Favorites') }}
                        </a>
                    @endif
                    
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            {{ __('Admin Dashboard') }}
                        </a>
                    @endif
                    
                    @if(Auth::user()->hasRole('rider'))
                        <a href="{{ route('rider.home') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            {{ __('Rider Dashboard') }}
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>