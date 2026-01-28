{{-- resources/views/settings/partials/content.blade.php --}}
@php
    $user = auth()->user();
@endphp

<div class="max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">Settings</h1>
        <p class="text-sm text-slate-500 mt-1">Manage your account details and security.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Left menu --}}
        <aside class="lg:col-span-4">
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-200">
                    <div class="text-xs uppercase tracking-widest text-slate-500 font-bold">Account</div>
                    <div class="mt-2 flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-slate-700">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-extrabold text-slate-900 leading-tight">{{ $user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <nav class="p-3 space-y-2 text-sm font-semibold">
                    <a href="{{ route('settings.index') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-xl
                       {{ request()->routeIs('settings.index') ? 'bg-slate-900 text-white' : 'hover:bg-slate-50 text-slate-700' }}">
                        Profile & Contact
                        <span class="text-xs opacity-70">Edit</span>
                    </a>

                    <a href="{{ route('settings.security') }}"
                       class="flex items-center justify-between px-4 py-3 rounded-xl
                       {{ request()->routeIs('settings.security') ? 'bg-slate-900 text-white' : 'hover:bg-slate-50 text-slate-700' }}">
                        Security
                        <span class="text-xs opacity-70">Password</span>
                    </a>
                </nav>
            </div>

            <div class="mt-4 rounded-2xl border border-slate-200 bg-white shadow-sm p-5">
                <div class="text-sm font-extrabold text-slate-900">Note</div>
                <div class="mt-1 text-xs text-slate-600">
                    Your <span class="font-bold">User ID</span> and <span class="font-bold">Name</span> are locked.
                    Only Admin can change those from management pages.
                </div>
            </div>
        </aside>

        {{-- Right content --}}
        <section class="lg:col-span-8 space-y-6">

            {{-- Flash --}}
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Page slot --}}
            @yield('settings_content')

        </section>
    </div>
</div>
