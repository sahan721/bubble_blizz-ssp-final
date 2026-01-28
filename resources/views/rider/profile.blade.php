@extends('rider.layouts.app')

@section('title', 'My Profile')
@section('page_title', 'My Profile')
@section('page_subtitle', 'Manage your rider details')

@section('content')

@if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700 text-sm">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-rose-700 text-sm">
        Please fix the errors and try again.
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Profile Card --}}
    <div class="lg:col-span-1">
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-slate-200 flex items-center justify-center font-black text-slate-700">
                    {{ strtoupper(substr($user->name ?? 'R', 0, 1)) }}
                </div>
                <div>
                    <div class="text-lg font-extrabold text-slate-900">{{ $user->name }}</div>
                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                </div>
            </div>

            <div class="mt-5 rounded-xl bg-slate-50 border border-slate-200 p-4">
                <div class="text-xs text-slate-500 font-semibold">Role</div>
                <div class="text-sm font-bold text-slate-900 mt-1">
                    {{ strtoupper($user->role ?? 'RIDER') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Update Form --}}
    <div class="lg:col-span-2">
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <h2 class="text-lg font-extrabold text-slate-900">Update Details</h2>
            <p class="text-xs text-slate-500 mt-1">Keep your info accurate for delivery communication</p>

            <form method="POST" action="{{ route('rider.profile.update') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label class="text-xs font-semibold text-slate-600">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0EA5B9]/40">
                    @error('name')
                        <div class="text-xs text-rose-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="text-xs font-semibold text-slate-600">Phone (optional)</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#0EA5B9]/40">
                    @error('phone')
                        <div class="text-xs text-rose-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="rounded-xl bg-[#0EA5B9] text-white px-5 py-2.5 text-sm font-semibold hover:opacity-90">
                        Save Changes
                    </button>

                    <a href="{{ route('rider.dashboard') }}"
                       class="rounded-xl bg-slate-100 text-slate-800 px-5 py-2.5 text-sm font-semibold hover:bg-slate-200">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
