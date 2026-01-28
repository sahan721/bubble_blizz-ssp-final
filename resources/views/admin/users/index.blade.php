@extends('admin.layouts.app')

@section('title', ucfirst($role).' Management')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">
                {{ ucfirst($role) }} Management
            </h1>
            <p class="text-sm text-slate-500">
                Manage all {{ $role }} accounts
            </p>
        </div>

        <a href="{{ $role === 'rider'
            ? route('admin.riders.create')
            : route('admin.customers.create') }}"
           class="rounded-xl bg-[#0EA5B9] px-5 py-2 text-white font-semibold hover:opacity-90">
            + Add {{ ucfirst($role) }}
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b">
                <tr class="text-left text-slate-600">
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @forelse($users as $user)
                <tr>
                    <td class="px-5 py-4 font-semibold text-slate-900">
                        {{ $user->name }}
                    </td>

                    <td class="px-5 py-4 text-slate-700">
                        {{ $user->email }}
                    </td>

                    <td class="px-5 py-4">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                            {{ $user->status === 'inactive'
                                ? 'bg-rose-100 text-rose-700'
                                : 'bg-emerald-100 text-emerald-700' }}">
                            {{ ucfirst($user->status ?? 'active') }}
                        </span>
                    </td>

                    <td class="px-5 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="px-4 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 font-semibold">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Delete this {{ $role }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-4 py-1.5 rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-10 text-center text-slate-500">
                        No {{ $role }}s found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
