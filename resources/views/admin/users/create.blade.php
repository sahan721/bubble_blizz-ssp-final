@extends('admin.layouts.app')

@section('title', 'Create '.ucfirst($role))

@section('content')
<div class="max-w-xl mx-auto">

    <h1 class="text-2xl font-extrabold text-slate-900 mb-6">
        Create {{ ucfirst($role) }}
    </h1>

    <form method="POST"
          action="{{ $role === 'rider'
            ? route('admin.riders.store')
            : route('admin.customers.store') }}"
          class="space-y-4 bg-white p-6 rounded-2xl border shadow-sm">
        @csrf

        <input name="name" placeholder="Full Name" class="w-full rounded-xl border px-4 py-2" required>
        <input name="email" type="email" placeholder="Email" class="w-full rounded-xl border px-4 py-2" required>
        <input name="password" type="password" placeholder="Password" class="w-full rounded-xl border px-4 py-2" required>

        <input name="phone" placeholder="Phone (optional)" class="w-full rounded-xl border px-4 py-2">
        <textarea name="address" placeholder="Address (optional)" class="w-full rounded-xl border px-4 py-2"></textarea>

        <select name="status" class="w-full rounded-xl border px-4 py-2">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <div class="flex gap-3">
            <button class="rounded-xl bg-[#0EA5B9] px-6 py-2 text-white font-semibold">
                Create
            </button>

            <a href="{{ $role === 'rider'
                ? route('admin.riders.index')
                : route('admin.customers.index') }}"
               class="rounded-xl bg-slate-200 px-6 py-2 font-semibold">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
