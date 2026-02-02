<aside class="w-72 hidden md:flex flex-col bg-[#0EA5B9] text-white min-h-screen">
    <div class="px-6 py-6 border-b border-white/20 flex items-center gap-3">
        <img src="{{ asset('images/bubbleblizz-logo.png') }}" alt="BubbleBlizz Logo" class="h-12 w-12 rounded-2xl object-contain">
        <div>
            <div class="text-xs uppercase tracking-widest opacity-80">RIDER</div>
            <div class="text-lg font-extrabold leading-tight">BubbleBlizz</div>
        </div>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 text-sm">
        @php $r = request()->route()?->getName(); @endphp

        <a href="{{ route('rider.home') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 {{ $r==='rider.home' ? 'bg-white/15' : '' }}">
            <span>🏠</span> <span class="font-semibold">Dashboard</span>
        </a>

        <a href="{{ route('rider.orders') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 {{ $r==='rider.orders' ? 'bg-white/15' : '' }}">
            <span>📦</span> <span class="font-semibold">Orders</span>
        </a>

    </nav>

        <a href="{{ route('settings.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 font-semibold">
             <span>Settings</span>
        </a>

    <div class="px-6 py-6 border-t border-white/20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full rounded-xl bg-white/15 hover:bg-white/25 px-4 py-3 font-semibold">
                Logout
            </button>
        </form>
    </div>
</aside>
