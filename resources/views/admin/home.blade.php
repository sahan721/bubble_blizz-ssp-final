@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Dashboard Hero Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">Admin Dashboard</h1>
                <p class="text-sm text-slate-500 mt-1">Monitor platform performance and manage orders</p>
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
            <span>📊</span> Platform Overview
        </h2>
            
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5">
    
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Total Orders</div>
                <div class="mt-2 text-3xl font-black text-slate-900">{{ $totalOrders }}</div>
                <div class="mt-2 text-xs text-slate-500">All time</div>
            </div>
    
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Pending</div>
                <div class="mt-2 text-3xl font-black text-amber-600">{{ $pending }}</div>
                <div class="mt-2 text-xs text-slate-500">Need attention</div>
            </div>
    
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Assigned</div>
                <div class="mt-2 text-3xl font-black text-blue-600">{{ $assigned }}</div>
                <div class="mt-2 text-xs text-slate-500">With riders</div>
            </div>
    
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Picked Up</div>
                <div class="mt-2 text-3xl font-black text-sky-600">{{ $pickedUp }}</div>
                <div class="mt-2 text-xs text-slate-500">On the way</div>
            </div>
    
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Delivered</div>
                <div class="mt-2 text-3xl font-black text-emerald-600">{{ $delivered }}</div>
                <div class="mt-2 text-xs text-slate-500">Successful</div>
            </div>
    
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                <div class="text-xs text-slate-500 font-semibold uppercase tracking-wide">Riders</div>
                <div class="mt-2 text-3xl font-black text-slate-900">{{ $riders }}</div>
                <div class="mt-2 text-xs text-slate-500">Active</div>
            </div>
    
        </div>
    </section>

    <!-- Recent Activity Section -->
    <section class="animate-fade-up">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                <span>📋</span> Recent Orders
            </h2>
            
            <a href="{{ route('admin.orders.index') }}"
               class="text-sm font-semibold text-[#0EA5B9] hover:underline transition-colors flex items-center gap-1">
                Manage Orders
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-600">
                        <th class="px-5 py-3 font-semibold text-xs uppercase tracking-wider">Order</th>
                        <th class="px-5 py-3 font-semibold text-xs uppercase tracking-wider">Customer</th>
                        <th class="px-5 py-3 font-semibold text-xs uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 font-semibold text-xs uppercase tracking-wider">Rider</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                    @forelse($recentOrders as $order)
                        <tr class="transition-colors hover:bg-slate-50">
                            <td class="px-5 py-4 font-bold text-slate-900">#{{ $order->id }}</td>
                            <td class="px-5 py-4">{{ $order->customer->name ?? 'N/A' }}</td>
                            <td class="px-5 py-4">
                                <<span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{
                                        $order->status === 'Pending' ? 'bg-amber-100 text-amber-800'
                                        : ($order->status === 'Assigned' ? 'bg-blue-100 text-blue-800'
                                        : ($order->status === 'Picked Up' ? 'bg-sky-100 text-sky-800'
                                        : ($order->status === 'Delivered' ? 'bg-emerald-100 text-emerald-800'
                                        : ($order->status === 'Cancelled' ? 'bg-rose-100 text-rose-800'
                                        : 'bg-slate-100 text-slate-800'))))
                                    }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-5 py-4">{{ $order->rider->name ?? 'Not assigned' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-4xl mb-2">📦</div>
                                    <div>No recent orders.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
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

</div>

@endsection
