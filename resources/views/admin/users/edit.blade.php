@extends('admin.layouts.app')

@section('title', 'Edit '.ucfirst($role))

@section('content')
<div class="max-w-xl mx-auto">

    <h1 class="text-2xl font-extrabold text-slate-900 mb-6">
        Edit {{ ucfirst($role) }}
    </h1>

    <form method="POST"
          action="{{ route('admin.users.update', $user) }}"
          class="space-y-4 bg-white p-6 rounded-2xl border shadow-sm">
        @csrf
        @method('PUT')

        <input name="name" value="{{ $user->name }}" class="w-full rounded-xl border px-4 py-2" required>
        <input name="email" type="email" value="{{ $user->email }}" class="w-full rounded-xl border px-4 py-2" required>

        <input name="password" type="password"
               placeholder="New password (leave blank to keep current)"
               class="w-full rounded-xl border px-4 py-2">

        <input name="phone" value="{{ $user->phone }}" class="w-full rounded-xl border px-4 py-2">
        <textarea name="address" class="w-full rounded-xl border px-4 py-2">{{ $user->address }}</textarea>

        <select name="status" class="w-full rounded-xl border px-4 py-2">
            <option value="active" @selected($user->status === 'active')>Active</option>
            <option value="inactive" @selected($user->status === 'inactive')>Inactive</option>
        </select>

        <div class="flex gap-3">
            <button class="rounded-xl bg-[#0EA5B9] px-6 py-2 text-white font-semibold">
                Update
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
