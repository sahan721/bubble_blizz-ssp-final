<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rider Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-slate-100">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    @include('rider.partials.sidebar')

    {{-- Main --}}
    <div class="flex-1 flex flex-col">

        {{-- Topbar --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b border-slate-200">
            <div class="px-4 md:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="history.back()" 
                            class="md:hidden rounded-lg bg-slate-100 p-2 hover:bg-slate-200 transition-colors focus:outline-none focus:ring-2 focus:ring-[#0EA5B9]/30">
                        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-lg md:text-xl font-extrabold text-slate-900">
                            @yield('page_title', 'Dashboard')
                        </h1>
                        <p class="text-xs md:text-sm text-slate-500">@yield('page_subtitle', 'Track deliveries & earnings')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Status Pill --}}
                    <div class="rounded-full px-3 py-1 text-xs font-semibold
                        bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Online
                    </div>

                    {{-- User --}}
                    <div class="flex items-center gap-2">
                        <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600">
                            {{ strtoupper(substr(auth()->user()->name ?? 'R', 0, 1)) }}
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? 'Rider' }}</div>
                            <div class="text-xs text-slate-500">{{ auth()->user()->email ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="px-4 md:px-8 py-6">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
