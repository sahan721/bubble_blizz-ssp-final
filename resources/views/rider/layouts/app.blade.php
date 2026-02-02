<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Rider Panel' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50">
    <div class="flex">
        <!-- Sidebar -->
        @include('rider.partials.sidebar')
        
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top Bar -->
            <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold">
                            R
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-900">Rider Panel</div>
                            <div class="text-xs text-slate-500">BubbleBlizz Delivery</div>
                        </div>
                    </div>

                    <nav class="flex items-center gap-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-2 rounded-lg text-sm font-medium text-white bg-slate-900 hover:bg-slate-800">
                                Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </header>

            <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
    