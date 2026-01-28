@extends('layouts.settings')

@section('title', 'Settings')
@section('page_title', 'Settings')
@section('page_subtitle', 'Update your email, phone and address. Name & ID are locked.')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left card: user summary --}}
    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-sky-500 to-cyan-500"></div>
            <div>
                <div class="text-xs uppercase tracking-widest text-slate-400 font-bold">Account</div>
                <div class="text-lg font-extrabold">{{ $user->name }}</div>
                <div class="text-sm text-slate-500">{{ $user->email }}</div>
            </div>
        </div>

        <div class="mt-6 space-y-3 text-sm">
            <div class="flex items-center justify-between rounded-2xl bg-slate-50 border border-slate-200 px-4 py-3">
                <span class="text-slate-500 font-semibold">User ID</span>
                <span class="font-extrabold">{{ $user->id }}</span>
            </div>

            <div class="flex items-center justify-between rounded-2xl bg-slate-50 border border-slate-200 px-4 py-3">
                <span class="text-slate-500 font-semibold">Role</span>
                <span class="font-extrabold">{{ ucfirst(strtolower($user->role ?? 'customer')) }}</span>
            </div>
        </div>

        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 text-xs text-slate-500">
            <span class="font-bold text-slate-700">Note:</span>
            Name and ID are locked. Only Admin can change them from management pages.
        </div>
    </div>

    {{-- Right: form --}}
    <div class="lg:col-span-2 rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-extrabold">Profile & Contact</h2>
                <p class="text-sm text-slate-500">These details are used for notifications and delivery contact.</p>
            </div>
        </div>

        <form class="mt-6 space-y-5" method="POST" action="{{ route('settings.profile.update') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-bold text-slate-700">Name (locked)</label>
                    <input value="{{ $user->name }}" disabled
                           class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-700" />
                </div>

                <div>
                    <label class="text-sm font-bold text-slate-700">User ID (locked)</label>
                    <input value="{{ $user->id }}" disabled
                           class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-slate-700" />
                </div>
            </div>

            <div>
                <label class="text-sm font-bold text-slate-700">Email</label>
                <input name="email" type="email" value="{{ old('email', $user->email) }}" required
                       class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-400" />
            </div>

            <div>
                <label class="text-sm font-bold text-slate-700">Phone</label>
                <input name="phone" type="text" value="{{ old('phone', $user->phone) }}"
                       class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-400" />
            </div>

            <div>
                <label class="text-sm font-bold text-slate-700">Address</label>
                <textarea name="address" rows="4"
                          class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-400"
                          placeholder="Enter your address...">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button class="rounded-2xl bg-slate-900 text-white px-6 py-3 font-bold hover:opacity-95">
                    Save Changes
                </button>

                <a href="{{ route('settings.security') }}"
                   class="rounded-2xl bg-slate-100 border border-slate-200 px-6 py-3 font-bold text-slate-700 hover:bg-slate-200">
                    Go to Security
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
