<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - BubbleBlizz</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-72 bg-[#0EA5B9] text-white hidden md:flex flex-col">
        <div class="px-6 py-6 border-b border-white/20 flex items-center gap-3">
            <img src="{{ asset('images/ic_bubbleblizz_logo_small.png') }}" alt="BubbleBlizz Logo" class="h-10 w-10 object-contain">
            <div>
                <div class="text-xs uppercase tracking-widest opacity-80">ADMIN</div>
                <div class="text-lg font-extrabold leading-tight">BubbleBlizz</div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
            <a href="{{ route('admin.home') }}"
               class="block rounded-xl px-4 py-3 hover:bg-white/10">
                Home
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="block rounded-xl px-4 py-3 hover:bg-white/10">
                Orders
            </a>

                        <a href="{{ route('admin.orders.index') }}"
            class="block px-4 py-2 rounded-lg hover:bg-white/10">
            Orders
            </a>

            <a href="{{ route('admin.customers.index') }}"
            class="block px-4 py-2 rounded-lg hover:bg-white/10">
            Customer Management
            </a>

            <a href="{{ route('admin.riders.index') }}"
            class="block px-4 py-2 rounded-lg hover:bg-white/10">
            Rider Management
            </a>


        </nav>

                    <a href="{{ route('settings.index') }}"
            class="block px-4 py-2 rounded-lg hover:bg-white/10">
            Settings
            </a>

          <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left rounded-xl px-4 py-3 hover:bg-white/10">
                    Logout
                </button>
            </form>
    </aside>

    {{-- Main --}}
    <main class="flex-1 p-4 md:p-8">
        @yield('content')
    </main>

</div>
</body>
</html>
