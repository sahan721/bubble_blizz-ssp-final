<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorSettingsController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function index()
    {
        $user = Auth::user();
        return view('settings.twofactor', compact('user'));
    }

    public function enable(Request $request)
    {
        $request->validate([
            'type' => 'required|in:totp,email',
        ]);

        $user = Auth::user();
        
        if ($request->type === 'totp') {
            // Generate secret for TOTP
            $secret = $this->google2fa->generateSecretKey();
            
            $user->update([
                'two_factor_enabled' => true,
                'two_factor_type' => 'totp',
                'two_factor_secret' => encrypt($secret),
                'two_factor_recovery_codes' => $this->generateRecoveryCodes(),
            ]);
        } else {
            // Email 2FA
            $user->update([
                'two_factor_enabled' => true,
                'two_factor_type' => 'email',
            ]);
        }

        return redirect()->route('two-factor.settings')->with('status', 'Two-factor authentication enabled successfully.');
    }

    public function disable(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'two_factor_enabled' => false,
            'two_factor_type' => null,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_email_code' => null,
            'two_factor_email_expires_at' => null,
        ]);

        // Clear 2FA session
        session()->forget('2fa');

        return redirect()->route('two-factor.settings')->with('status', 'Two-factor authentication disabled successfully.');
    }

    public function showQrCode()
    {
        $user = Auth::user();
        
        if (!$user->two_factor_secret) {
            return redirect()->route('two-factor.settings');
        }

        $secret = decrypt($user->two_factor_secret);
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            'BubbleBlizz',
            $user->email,
            $secret
        );

        return view('settings.twofactor-qr', compact('qrCodeUrl', 'user'));
    }

    public function confirmTotp(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $secret = decrypt($user->two_factor_secret);
        
        if ($this->google2fa->verifyKey($secret, $request->code)) {
            session(['2fa.verified' => true]);
            return redirect()->route('two-factor.settings')->with('status', 'TOTP authentication confirmed successfully.');
        }

        return back()->withErrors(['code' => 'Invalid code. Please try again.']);
    }

    public function generateRecoveryCodes()
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = Hash::make(str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT));
        }
        
        return $codes;
    }

    public function showRecoveryCodes()
    {
        $user = Auth::user();
        $codes = $user->two_factor_recovery_codes ?? [];
        
        return view('settings.twofactor-recovery', compact('codes'));
    }
}