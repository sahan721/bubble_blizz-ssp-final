<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /* =========================
     * LIST PAGES
     * ========================= */

    public function index(Request $request)
    {
        $role = $request->get('role');
        
        $query = User::query();
        
        // Filter by role if specified
        if ($role && in_array(strtolower($role), ['customer', 'rider'])) {
            $query->whereRaw('LOWER(role) = ?', [strtolower($role)]);
        } else {
            // Default to showing all non-admin users
            $query->whereRaw('LOWER(role) IN (?, ?)', ['customer', 'rider']);
        }
        
        $users = $query->latest()->paginate(10);
        
        return view('admin.users.index', compact('users', 'role'));
    }

    public function customers()
    {
        $role = 'customer';

        $users = User::whereRaw('LOWER(role) = ?', [$role])
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users', 'role'));
    }

    public function riders()
    {
        $role = 'rider';

        $users = User::whereRaw('LOWER(role) = ?', [$role])
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users', 'role'));
    }

    /* =========================
     * CREATE FORMS
     * ========================= */

    public function create(Request $request)
    {
        $role = $request->get('role', 'customer');
        
        // Validate role
        if (!in_array(strtolower($role), ['customer', 'rider'])) {
            $role = 'customer';
        }
        
        return view('admin.users.create', compact('role'));
    }

    public function createCustomer()
    {
        $role = 'customer';
        return view('admin.users.create', compact('role'));
    }

    public function createRider()
    {
        $role = 'rider';
        return view('admin.users.create', compact('role'));
    }

    /* =========================
     * STORE
     * ========================= */

    public function store(Request $request)
    {
        $role = $request->get('role', 'customer');
        
        // Validate role
        if (!in_array(strtolower($role), ['customer', 'rider'])) {
            $role = 'customer';
        }
        
        return $this->storeByRole($request, $role);
    }

    public function storeCustomer(Request $request)
    {
        return $this->storeByRole($request, 'customer');
    }

    public function storeRider(Request $request)
    {
        return $this->storeByRole($request, 'rider');
    }

    private function storeByRole(Request $request, string $role)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'address'  => ['nullable', 'string', 'max:500'],
            'status'   => ['nullable', 'in:active,inactive'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
            'status'   => $request->status ?? 'active',
            'role'     => $role, // ✅ force role
        ]);

        return redirect()
            ->route($role === 'rider' ? 'admin.riders.index' : 'admin.customers.index')
            ->with('success', ucfirst($role) . ' created successfully.');
    }

    /* =========================
     * EDIT FORM
     * ========================= */

    public function edit(User $user)
    {
        // only allow editing customer/rider from these pages
        $role = strtolower($user->role ?? '');
        if (!in_array($role, ['customer', 'rider'], true)) {
            abort(403);
        }

        return view('admin.users.edit', compact('user', 'role'));
    }

    /* =========================
     * UPDATE
     * ========================= */

    public function update(Request $request, User $user)
    {
        $role = strtolower($user->role ?? '');
        if (!in_array($role, ['customer', 'rider'], true)) {
            abort(403);
        }

        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'status'  => ['nullable', 'in:active,inactive'],
            'password'=> ['nullable', 'string', 'min:6'],
        ]);

        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->address = $request->address;
        $user->status  = $request->status ?? $user->status;

        // ✅ only update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // ✅ protect role (admin should not accidentally change it here)
        $user->role = $role;

        $user->save();

        return redirect()
            ->route($role === 'rider' ? 'admin.riders.index' : 'admin.customers.index')
            ->with('success', ucfirst($role) . ' updated successfully.');
    }

    /* =========================
     * DELETE
     * ========================= */

    public function destroy(User $user)
    {
        $role = strtolower($user->role ?? '');
        if (!in_array($role, ['customer', 'rider'], true)) {
            abort(403);
        }

        $user->delete();

        return redirect()
            ->route($role === 'rider' ? 'admin.riders.index' : 'admin.customers.index')
            ->with('success', ucfirst($role) . ' deleted successfully.');
    }
}
