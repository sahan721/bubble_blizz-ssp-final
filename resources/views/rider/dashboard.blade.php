@extends('rider.layouts.app')

@section('title', 'Rider Dashboard')
@section('page_title', 'Rider Dashboard')
@section('page_subtitle', 'Today’s deliveries, progress, and quick actions')

@section('content')

<!-- Dashboard Hero Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Rider Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1">Manage your deliveries and track earnings</p>
        </div>
        <div class="hidden md:flex items-center gap-2 text-sm text-slate-500">
            <span>Dashboard</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="font-semibold">Home</span>
        </div>
    </div>
</div>

<!-- Overview Section -->
<section class="mb-8 animate-fade-up">
    <h2 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
        <span>📊</span> Today's Performance
    </h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Assigned (Active)</div>
            <div class="mt-2 text-3xl font-black text-slate-900">{{ $assignedCount }}</div>
            <div class="mt-2 text-xs text-slate-500">Orders in progress</div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Delivered Today</div>
            <div class="mt-2 text-3xl font-black text-emerald-600">{{ $deliveredTodayCount }}</div>
            <div class="mt-2 text-xs text-slate-500">Completed successfully</div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Pending</div>
            @php
                // Pending = Assigned only (Picked Up is already in progress)
                $pendingAssigned = $recentOrders->where('status', 'Assigned')->count();
            @endphp
            <div class="mt-2 text-3xl font-black text-amber-600">{{ $pendingAssigned }}</div>
            <div class="mt-2 text-xs text-slate-500">Waiting to pick up</div>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
            <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Earnings (Today)</div>
            <div class="mt-2 text-3xl font-black text-slate-900">Rs. {{ number_format($todayEarnings, 2) }}</div>
            <div class="mt-2 text-xs text-slate-500">Delivery fees + tips</div>
        </div>
    </div>
</section>

{{-- Quick Actions + Recent Activity Section --}}
<section class="mb-8 animate-fade-up">
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Quick Actions --}}
        <div class="xl:col-span-1">
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                        <span>⚡</span> Quick Actions
                    </h2>
                    <span class="text-xs text-slate-500">Rider tools</span>
                </div>

                <div class="mt-4 space-y-3">
                    <a href="{{ route('rider.orders') }}"
                       class="block w-full rounded-xl bg-slate-900 text-white px-4 py-3 font-semibold hover:bg-slate-800 transition-colors hover:shadow-md">
                        View My Orders
                    </a>

                    {{-- These will be wired later (Step: Rider online/offline + location update) --}}
                    <button type="button"
                            class="block w-full rounded-xl bg-[#0EA5B9] text-white px-4 py-3 font-semibold hover:bg-[#0c8ca0] transition-colors hover:shadow-md">
                        Toggle Online / Offline
                    </button>

                    <button type="button"
                            class="block w-full rounded-xl bg-slate-100 text-slate-800 px-4 py-3 font-semibold hover:bg-slate-200 transition-colors hover:shadow-md">
                        Update My Location
                    </button>
                </div>

                <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <div class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span>💡</span> Pro Tip
                    </div>
                    <div class="text-xs text-slate-600 mt-1">
                        Keep your status <span class="font-semibold">Online</span> to receive assigned orders.
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Recent Orders --}}
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="p-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                            <span>📦</span> Recent Orders
                        </h2>
                        <p class="text-xs text-slate-500">Your latest assigned deliveries</p>
                    </div>
                    <a href="{{ route('rider.orders') }}" class="text-sm font-semibold text-[#0EA5B9] hover:underline transition-colors flex items-center gap-1">
                        See all
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="border-t border-slate-200">
                    <div class="divide-y divide-slate-200">
                        @forelse($recentOrders as $order)

                            @php
                                // Badge styling by status
                                $badge = match ($order->status) {
                                    'Assigned'  => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Picked Up' => 'bg-sky-50 text-sky-700 border-sky-200',
                                    'Delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default     => 'bg-slate-50 text-slate-700 border-slate-200',
                                };

                                // Area display (fallback)
                                $area = $order->delivery_address ?: 'N/A';
                            @endphp

                            <div class="p-5 flex items-center justify-between gap-3 transition-colors hover:bg-slate-50">
                                <div>
                                    <div class="text-sm font-bold text-slate-900">Order #{{ $order->id }}</div>
                                    <div class="text-xs text-slate-500">
                                        Customer: {{ $order->customer->name ?? 'N/A' }} • {{ $area }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $badge }}">
                                        {{ $order->status }}
                                    </span>

                                    <a href="{{ route('rider.orders') }}"
                                       class="text-sm font-semibold text-slate-700 hover:underline transition-colors">
                                        Open
                                    </a>
                                </div>
                            </div>

                        @empty
                            <div class="p-8 text-center text-slate-500 text-sm">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-4xl mb-2">📦</div>
                                    <div>No orders assigned yet.</div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Route Map --}}
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                            <span>🗺️</span> Route Map
                        </h2>
                        <p class="text-xs text-slate-500">Live tracking (integration pending)</p>
                    </div>
                </div>

                <div class="mt-4 h-64 rounded-2xl bg-slate-100 border border-dashed border-slate-300 flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-sm font-bold text-slate-700">Google Maps Integration</div>
                        <div class="text-xs text-slate-500 mt-1">Real-time route optimization coming soon</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Back to Top Button -->
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
        id="backToTop"
        class="fixed bottom-8 right-8 hidden md:flex items-center gap-2 rounded-full bg-[#0EA5B9] text-white px-5 py-3 font-semibold shadow-xl hover:bg-[#0c8ca0] hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 z-50">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
    </svg>
    Top
</button>

<style>
/* Custom Animations */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-up {
    animation: fadeUp 0.6s ease-out forwards;
}

/* Stagger animations */
section:nth-child(2) { animation-delay: 0.1s; }
section:nth-child(3) { animation-delay: 0.2s; }

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

/* Focus styles for accessibility */
button:focus-visible, a:focus-visible {
    outline: 2px solid #0EA5B9;
    outline-offset: 2px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .animate-fade-up {
        animation: none;
    }
}
</style>

<script>
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
@endsection
