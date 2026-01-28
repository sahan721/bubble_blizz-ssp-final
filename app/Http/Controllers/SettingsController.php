<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * Show settings main page
     */
    public function index()
    {
        return view('settings.index', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update profile details (email, phone, address)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update([
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Show security settings page
     */
    public function security()
    {
        return view('settings.security', [
            'user' => Auth::user(),
        ]);
    }
}
