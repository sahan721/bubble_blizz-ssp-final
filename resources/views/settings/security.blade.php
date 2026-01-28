@extends('layouts.settings')

@section('title', 'Security')
@section('page_title', 'Security')
@section('page_subtitle', 'Change your password securely.')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
        <h3 class="text-lg font-extrabold">Security Tips</h3>
        <ul class="mt-4 space-y-2 text-sm text-slate-600 list-disc pl-5">
            <li>Use at least 8 characters</li>
            <li>Don’t reuse old passwords</li>
            <li>Use letters + numbers for better safety</li>
        </ul>

        <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-500">
            If you forget your password, you can use the <b>Forgot Password</b> on login.
        </div>
    </div>

    <div class="lg:col-span-2 rounded-3xl border border-slate-200 bg-white shadow-sm p-6">
        <h2 class="text-xl font-extrabold">Change Password</h2>
        <p class="text-sm text-slate-500">Enter your current password first, then a new one.</p>

        <form class="mt-6 space-y-5" method="POST" action="{{ route('settings.password.update') }}">
            @csrf

            <div>
                <label class="text-sm font-bold text-slate-700">Current Password</label>
                <input name="current_password" type="password" required
                       class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-400" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-bold text-slate-700">New Password</label>
                    <input name="password" type="password" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>

                <div>
                    <label class="text-sm font-bold text-slate-700">Confirm Password</label>
                    <input name="password_confirmation" type="password" required
                           class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-sky-400" />
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="rounded-2xl bg-slate-900 text-white px-6 py-3 font-bold hover:opacity-95">
                    Update Password
                </button>

                <a href="{{ route('settings.index') }}"
                   class="rounded-2xl bg-slate-100 border border-slate-200 px-6 py-3 font-bold text-slate-700 hover:bg-slate-200">
                    Back to Profile
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
