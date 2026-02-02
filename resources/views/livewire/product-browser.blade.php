    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="space-y-8">

    {{-- Search + Filter --}}
    <div class="flex flex-col md:flex-row gap-3">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Search products..."
            class="w-full md:flex-1 rounded-xl border border-gray-300 px-4 py-3"
        >

        <select
            wire:model.live="category"
            class="w-full md:w-60 rounded-xl border border-gray-300 px-4 py-3"
        >
            <option value="all">All Categories</option>
            <option value="juices">Fruit Juices</option>
            <option value="soft-drinks">Soft Drinks</option>
            <option value="dairy">Dairy Drinks</option>
            <option value="energy-drinks">Energy Drinks</option>
        </select>
    </div>

    {{-- Notification Area --}}
    @if(session()->has('message'))
        <div class="rounded-xl bg-green-100 border border-green-400 text-green-700 px-6 py-4 font-semibold">
            {{ session('message') }}
        </div>
    @endif

    {{-- Grouped sections with anchor IDs --}}
    @forelse($grouped as $cat => $items)
        <div class="space-y-4">
            <!-- Invisible anchor for smooth scrolling -->
            <div id="{{ $cat }}" class="scroll-mt-32"></div>
            
            <div class="flex items-center justify-between border-b pb-2">
                <h2 class="text-xl font-extrabold text-gray-900">
                    {{ $labels[$cat] ?? ucwords(str_replace('-', ' ', $cat)) }}
                </h2>
                <span class="text-sm text-gray-500">{{ $items->count() }} items</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($items as $p)
                    <div class="rounded-2xl bg-white border border-gray-200 overflow-hidden shadow-sm">
                        <div class="bg-gray-100 p-4 flex items-center justify-center">
                            <img
                                src="{{ asset($p->image) ?: asset('images/img_placeholder.png') }}"
                                alt="{{ $p->name }}"
                                class="h-28 w-28 object-contain"
                            >
                        </div>

                        <div class="p-4">
                            <div class="font-extrabold text-gray-900">{{ $p->name }}</div>
                            <div class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $p->description }}</div>
                        
                            <div class="font-extrabold text-[#1f4fbf] mt-3">
                                LKR {{ number_format((float)$p->price, 2) }}
                            </div>
                        
                            <div class="text-xs text-gray-500 mt-1">
                                Stock: {{ $p->stock }}
                            </div>
                                                    
                            <!-- Quantity Selector -->
                            <div class="mt-3">
                                <label class="text-xs text-gray-600">Quantity:</label>
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                    <button type="button" 
                                          wire:click="updateQuantity({{ $p->id }}, {{ max(1, $quantities[$p->id] - 1) }})"
                                          class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">
                                        -
                                    </button>
                                    <input type="number" 
                                           wire:model="quantities.{{ $p->id }}" 
                                           min="1" 
                                           max="{{ $p->stock }}" 
                                           class="w-12 text-center border-0 focus:outline-none focus:ring-0" 
                                           readonly>
                                    <button type="button" 
                                          wire:click="updateQuantity({{ $p->id }}, {{ $quantities[$p->id] + 1 }})"
                                          class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">
                                        +
                                    </button>
                                </div>
                            </div>
                                                    
                            <!-- Action Buttons -->
                            <div class="flex gap-2 mt-3">
                                @auth
                                    <button type="button" 
                                            wire:click="addToCart({{ $p->id }})" 
                                            class="flex-1 bg-[#1f4fbf] hover:bg-[#173c92] text-white py-2 px-3 rounded-lg text-sm font-semibold transition-colors">
                                        Add to Cart
                                    </button>
                                                        
                                    <button type="button" 
                                            wire:click="toggleFavorite({{ $p->id }})" 
                                            class="p-2 border {{ in_array($p->id, $favoriteIds ?? []) ? 'bg-red-500 border-red-500 text-white' : 'border-red-500 text-red-500 hover:bg-red-500 hover:text-white' }} rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="{{ in_array($p->id, $favoriteIds ?? []) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                @else
                                    <button type="button" 
                                            onclick="window.location='{{ route('login') }}'" 
                                            class="flex-1 bg-[#1f4fbf] hover:bg-[#173c92] text-white py-2 px-3 rounded-lg text-sm font-semibold transition-colors">
                                        Add to Cart
                                    </button>
                                                        
                                    <button type="button" 
                                            onclick="window.location='{{ route('login') }}'" 
                                            class="p-2 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-4">
            No products found.
        </div>
    @endforelse

        </div>
    </div>