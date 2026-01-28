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
        <div class="fixed top-4 right-4 z-50 rounded-xl bg-green-100 border border-green-400 text-green-700 px-6 py-4 shadow-lg font-semibold">
            {{ session('message') }}
        </div>
    @endif

    <div x-data="{ show: @entangle('notification') !== null }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed top-4 right-4 z-50"
         x-init="setTimeout(() => show = false, 3000)">
        <template x-if="$wire.notification">
            <div 
                :class="{
                    'bg-green-100 border-green-400 text-green-700': $wire.notification.type === 'success',
                    'bg-red-100 border-red-400 text-red-700': $wire.notification.type === 'error',
                    'bg-blue-100 border-blue-400 text-blue-700': $wire.notification.type === 'info',
                    'bg-yellow-100 border-yellow-400 text-yellow-700': $wire.notification.type === 'warning'
                }"
                class="rounded-xl border px-6 py-4 shadow-lg font-semibold"
                role="alert"
            >
                <div class="flex items-center gap-2">
                    <template x-if="$wire.notification.type === 'success'">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </template>
                    <template x-if="$wire.notification.type === 'error'">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </template>
                    <template x-if="$wire.notification.type === 'info'">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                    <template x-if="$wire.notification.type === 'warning'">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </template>
                    <span x-text="$wire.notification.message"></span>
                </div>
            </div>
        </template>
    </div>

    {{-- Grouped sections --}}
    @forelse($grouped as $cat => $items)
        <div class="space-y-4">
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
                                src="{{ $p->image ?: asset('images/img_placeholder.png') }}"
                                alt="{{ $p->name }}"
                                class="h-28 w-28 object-contain"
                                onerror="this.onerror=null;this.src='{{ asset('images/img_placeholder.png') }}';"
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
                                <button type="button" 
                                        wire:click="addToCart({{ $p->id }})" 
                                        class="flex-1 bg-[#1f4fbf] hover:bg-[#173c92] text-white py-2 px-3 rounded-lg text-sm font-semibold transition-colors">
                                    Add to Cart
                                </button>
                                                        
                                <button type="button" 
                                        wire:click="toggleFavorite({{ $p->id }})" 
                                        class="p-2 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
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