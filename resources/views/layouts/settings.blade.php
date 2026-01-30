<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Settings') - Bubble Blizz</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900">
    {{-- Top Bar --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img
                    src="{{ asset('images/bubbleblizz-logo.png') }}"
                    alt="BubbleBlizz Logo"
                    class="h-9 w-9 rounded-xl object-contain"
                />

                <div>
                    <div class="text-sm font-extrabold leading-none">Bubble Blizz</div>
                    <div class="text-xs text-slate-500 leading-none">Account Settings</div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs px-3 py-1 rounded-full bg-slate-100 border border-slate-200 font-semibold">
                    {{ ucfirst(strtolower(auth()->user()->role ?? 'customer')) }}
                </span>

                <a href="{{ auth()->user()->role === 'admin' ? route('admin.home') : (auth()->user()->role === 'rider' ? route('rider.home') : route('customer.home')) }}"
                   class="text-sm font-semibold text-slate-700 hover:text-slate-900">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </header>

    {{-- Page --}}
    <main class="mx-auto max-w-7xl px-6 py-10">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">@yield('page_title', 'Settings')</h1>
                <p class="text-slate-500 mt-1">@yield('page_subtitle', 'Manage your account details and security.')</p>
            </div>

            {{-- Tabs --}}
            <div class="flex gap-2">
                <a href="{{ route('settings.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold border
                   {{ request()->routeIs('settings.index') ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                    Profile
                </a>

                <a href="{{ route('settings.security') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold border
                   {{ request()->routeIs('settings.security') ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                    Security
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800 font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800">
                <div class="font-bold mb-1">Fix these:</div>
                <ul class="list-disc pl-6 text-sm">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-8 text-center text-xs text-slate-400">
        Bubble Blizz • Settings
    </footer>
</body>
</html>
