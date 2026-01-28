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
