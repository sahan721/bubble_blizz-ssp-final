<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bubble Blizz - Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">

    @include('customer.partials.topnav')

    <!-- Dashboard Hero Header -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#1f4fbf] to-[#2d5bc7] text-white py-16 md:py-24">
        <div class="absolute inset-0 bg-cover bg-center opacity-20"
            style="background-image: url('{{ asset('images/img_banner.png') }}');"></div>
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold">Customer Dashboard</h1>
                    <p class="text-lg md:text-xl opacity-90 mt-1">Manage your orders and discover new beverages</p>
                </div>
                <div class="hidden md:flex items-center gap-2 text-sm text-white/80">
                    <span>Dashboard</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="font-semibold">Home</span>
                </div>
            </div>

            <div class="mt-8 text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <img src="{{ asset('images/bubbleblizz-logo.png') }}" alt="Bubble Blizz Logo"
                        class="h-12 w-12 object-contain">
                    <h2 class="text-2xl md:text-4xl font-extrabold">
                        Welcome back, <span class="text-yellow-300">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>!
                    </h2>
                </div>
                <p class="text-lg md:text-xl opacity-90 max-w-3xl mx-auto mb-8">
                    Ready for your next refreshing beverage adventure?
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('customer.products') }}"
                        class="group rounded-xl bg-white text-[#1f4fbf] px-8 py-4 text-lg font-bold hover:bg-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 flex items-center gap-2">
                        <span>🛍️</span> Shop Now
                    </a>
                    <a href="{{ route('customer.orders.index') }}"
                        class="text-sm text-[#1f4fbf] hover:text-[#173c92] font-semibold hover:underline transition-colors flex items-center gap-1">
                        View All Orders
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-12">

        @include('customer.partials.back')

        <!-- Quick Categories -->
        <section class="mt-12 animate-slide-up">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-6 text-center">Browse by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('customer.products', ['category' => 'juices']) }}"
                    class="group rounded-2xl bg-gradient-to-br from-amber-100 to-amber-200 p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-amber-200 hover:border-amber-300">
                    <div class="flex flex-col items-center">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🍹</div>
                        <div class="text-lg font-bold text-gray-900 mb-1">Fruit Juices</div>
                        <div class="text-sm text-gray-600">Fresh & natural</div>
                    </div>
                </a>

                <a href="{{ route('customer.products', ['category' => 'soft-drinks']) }}"
                    class="group rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-blue-200 hover:border-blue-300">
                    <div class="flex flex-col items-center">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🥤</div>
                        <div class="text-lg font-bold text-gray-900 mb-1">Soft Drinks</div>
                        <div class="text-sm text-gray-600">Classic sodas</div>
                    </div>
                </a>

                <a href="{{ route('customer.products', ['category' => 'dairy']) }}"
                    class="group rounded-2xl bg-gradient-to-br from-green-100 to-green-200 p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-green-200 hover:border-green-300">
                    <div class="flex flex-col items-center">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🥛</div>
                        <div class="text-lg font-bold text-gray-900 mb-1">Dairy Drinks</div>
                        <div class="text-sm text-gray-600">Milk & shakes</div>
                    </div>
                </a>

                <a href="{{ route('customer.products', ['category' => 'energy-drinks']) }}"
                    class="group rounded-2xl bg-gradient-to-br from-rose-100 to-rose-200 p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-rose-200 hover:border-rose-300">
                    <div class="flex flex-col items-center">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">⚡</div>
                        <div class="text-lg font-bold text-gray-900 mb-1">Energy Drinks</div>
                        <div class="text-sm text-gray-600">Boost energy</div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Status Messages -->
        @if (session('status'))
            <div
                class="mt-8 rounded-2xl bg-gradient-to-r from-green-100 to-emerald-50 border border-green-200 px-6 py-4 text-green-800 font-semibold shadow-sm animate-pulse">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div
                class="mt-8 rounded-2xl bg-gradient-to-r from-red-100 to-rose-50 border border-red-200 px-6 py-4 text-red-800 font-semibold shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $errors->first() }}
                </div>
            </div>
        @endif

        <!-- Featured Products -->
        <section class="mt-16 animate-slide-up">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-3">✨ Featured Products</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Discover our most popular beverages handpicked just for you
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($products as $p)
                    <div
                        class="group rounded-2xl bg-white shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                        <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-6 flex items-center justify-center">
                            <img src="{{ asset($p->image) ?? 'https://via.placeholder.com/200x200?text=No+Image' }}"
                                class="h-32 w-32 object-contain group-hover:scale-110 transition-transform duration-300"
                                alt="{{ $p->name }}"
                                onerror="this.src='https://via.placeholder.com/200x200?text=🥤'">
                        </div>

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h4
                                    class="text-lg font-extrabold text-gray-900 group-hover:text-[#1f4fbf] transition-colors">
                                    {{ $p->name }}</h4>

                                <!-- Favorite -->
                                <form method="POST" action="{{ url('/api/customer/favorites/toggle') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    <button type="submit"
                                        class="text-xl transition-all duration-200 transform hover:scale-110
                                        {{ in_array($p->id, $favoriteIds ?? []) ? 'text-red-500 drop-shadow-sm' : 'text-gray-300 hover:text-red-400' }}"
                                        title="Favorite">
                                        {{ in_array($p->id, $favoriteIds ?? []) ? '♥' : '♡' }}
                                    </button>
                                </form>
                            </div>

                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                {{ $p->description }}
                            </p>

                            <div class="text-xl font-extrabold text-[#1f4fbf] mb-4">
                                LKR {{ number_format((float) $p->price, 2) }}
                            </div>

                            <!-- Quantity Selector -->
                            <div class="flex items-center gap-3 mb-4">
                                <span class="text-sm text-gray-700 font-medium">Qty:</span>
                                <select form="addcart-home-{{ $p->id }}" name="qty"
                                    class="w-20 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-[#1f4fbf]/20 focus:border-[#1f4fbf] transition-all">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Add to Cart -->
                            <form id="addcart-home-{{ $p->id }}" method="POST"
                                action="{{ route('customer.cart.add') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <button type="submit"
                                    class="w-full rounded-xl bg-gradient-to-r from-[#1f4fbf] to-[#2d5bc7] py-3 text-white font-bold hover:from-[#173c92] hover:to-[#1f4fbf] transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-[#1f4fbf]/30">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="text-6xl mb-4">🥤</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No featured products yet</h3>
                        <p class="text-gray-600 mb-6">Check back soon for exciting new beverages!</p>
                        <a href="{{ route('customer.products') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#1f4fbf] px-6 py-3 text-white font-semibold hover:bg-[#1a43a6] transition-colors">
                            Browse All Products
                        </a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Recent Orders Preview -->
        <section class="mt-16 animate-slide-up">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-extrabold text-gray-900 flex items-center gap-2">
                    <span>📦</span> Your Recent Orders
                </h2>
                <a href="{{ route('customer.orders.index') }}"
                    class="text-sm text-[#1f4fbf] hover:text-[#173c92] font-semibold hover:underline transition-colors flex items-center gap-1">
                    View All Orders
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 max-w-md mx-auto">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="text-sm font-bold text-gray-900 mb-1">Order #BLZ-001</div>
                        <div class="text-xs text-gray-500 mb-1">Today, Jan 21, 2026</div>
                        <div class="text-xs text-gray-500">3 items • 2.5 km</div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">Preparing</span>
                </div>

                <div class="flex items-center justify-between text-sm mb-4">
                    <span class="text-gray-600">Estimated Delivery</span>
                    <span class="font-bold text-gray-900">25 mins</span>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 font-medium">Total</span>
                        <span class="text-xl font-extrabold text-[#1f4fbf]">LKR 1,250.00</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="mt-20 animate-slide-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-3">🌟 Why Choose Bubble Blizz?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">We're committed to delivering the best beverage experience
                    in town</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="group text-center bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div
                        class="mx-auto w-20 h-20 rounded-full bg-gradient-to-br from-[#1f4fbf] to-[#2d5bc7] flex items-center justify-center text-3xl mb-5 group-hover:scale-110 transition-transform duration-300">
                        🚚
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Lightning Fast</h3>
                    <p class="text-gray-600">Get your favorite drinks delivered within 30 minutes. We're quick,
                        reliable, and always on time.</p>
                </div>

                <div
                    class="group text-center bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div
                        class="mx-auto w-20 h-20 rounded-full bg-gradient-to-br from-[#1f4fbf] to-[#2d5bc7] flex items-center justify-center text-3xl mb-5 group-hover:scale-110 transition-transform duration-300">
                        ⭐
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Premium Quality</h3>
                    <p class="text-gray-600">Only the finest ingredients and freshest beverages. Quality you can taste
                        in every sip.</p>
                </div>

                <div
                    class="group text-center bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div
                        class="mx-auto w-20 h-20 rounded-full bg-gradient-to-br from-[#1f4fbf] to-[#2d5bc7] flex items-center justify-center text-3xl mb-5 group-hover:scale-110 transition-transform duration-300">
                        👑
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Blizz Club</h3>
                    <p class="text-gray-600">Join our premium membership for exclusive discounts, free delivery, and
                        VIP treatment.</p>
                </div>
            </div>
        </section>

        <!-- Premium Membership CTA -->
        <section
            class="mt-20 rounded-3xl bg-gradient-to-r from-[#1f4fbf] to-[#2d5bc7] text-white shadow-2xl overflow-hidden relative">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative p-10 text-center">
                <div class="mb-8">
                    <div class="text-2xl font-extrabold mb-2 flex items-center justify-center gap-2">
                        <span>☀️</span> Blizz Premium
                    </div>
                    <p class="text-lg opacity-90 max-w-2xl mx-auto">Unlock exclusive benefits and save more on every
                        order!</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div
                        class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 text-center hover:bg-white/30 transition-all duration-300">
                        <div class="text-3xl mb-3">🚚</div>
                        <div class="text-lg font-bold mb-2">Free Delivery</div>
                        <div class="text-sm opacity-90">No delivery charges ever</div>
                    </div>
                    <div
                        class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 text-center hover:bg-white/30 transition-all duration-300">
                        <div class="text-3xl mb-3">💰</div>
                        <div class="text-lg font-bold mb-2">20% Discount</div>
                        <div class="text-sm opacity-90">Save on all beverages</div>
                    </div>
                    <div
                        class="bg-white/20 backdrop-blur-sm rounded-2xl p-6 text-center hover:bg-white/30 transition-all duration-300">
                        <div class="text-3xl mb-3">👑</div>
                        <div class="text-lg font-bold mb-2">VIP Support</div>
                        <div class="text-sm opacity-90">Priority customer service</div>
                    </div>
                </div>

                <button
                    class="rounded-xl bg-white text-[#1f4fbf] px-8 py-4 text-lg font-bold hover:bg-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    Join Blizz Premium Today
                </button>
            </div>
        </section>

    </main>

    <!-- Custom Styles -->
    <style>
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        /* Stagger animations for sections */
        section:nth-child(2) {
            animation-delay: 0.1s;
        }

        section:nth-child(3) {
            animation-delay: 0.2s;
        }

        section:nth-child(4) {
            animation-delay: 0.3s;
        }

        section:nth-child(5) {
            animation-delay: 0.4s;
        }

        /* Line clamp for product descriptions */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Focus styles for accessibility */
        button:focus-visible,
        a:focus-visible {
            outline: 2px solid #1f4fbf;
            outline-offset: 2px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .animate-fade-in,
            .animate-slide-up {
                animation: none;
            }
        }

        <style>

        /* Hide back to top button initially */
        #backToTop {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        #backToTop.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="backToTop"
        class="fixed bottom-8 right-8 hidden md:flex items-center gap-2 rounded-full bg-[#1f4fbf] text-white px-5 py-3 font-semibold shadow-xl hover:bg-[#173c92] hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 z-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
        </svg>
        Top
    </button>

    <script>
        // Simple animation trigger for sections
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, {
                threshold: 0.1
            });

            sections.forEach(section => {
                observer.observe(section);
            });
        });

        // Show/hide back to top button
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
    </script>

</body>

</html>
