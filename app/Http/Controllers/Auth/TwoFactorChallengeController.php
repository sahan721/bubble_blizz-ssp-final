<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorChallengeController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    public function show()
    {
        $user = Auth::user();
        
        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('login');
        }

        // If it's email 2FA, generate and send code
        if ($user->two_factor_type === 'email') {
            $this->sendEmailCode($user);
        }

        return view('auth.twofactor-challenge', compact('user'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = Auth::user();
        
        if (!$user || !$user->two_factor_enabled) {
            return redirect()->route('login');
        }

        $code = $request->code;

        // Check recovery codes first
        if ($this->verifyRecoveryCode($user, $code)) {
            session(['2fa.verified' => true]);
            return $this->redirectToIntended();
        }

        // Check TOTP or email code
        if ($user->two_factor_type === 'totp') {
            if ($this->verifyTotp($user, $code)) {
                session(['2fa.verified' => true]);
                return $this->redirectToIntended();
            }
        } elseif ($user->two_factor_type === 'email') {
            if ($this->verifyEmailCode($user, $code)) {
                session(['2fa.verified' => true]);
                return $this->redirectToIntended();
            }
        }

        return back()->withErrors(['code' => 'Invalid code. Please try again.']);
    }

    protected function verifyTotp($user, $code)
    {
        $secret = decrypt($user->two_factor_secret);
        return $this->google2fa->verifyKey($secret, $code);
    }

    protected function verifyEmailCode($user, $code)
    {
        if (!$user->two_factor_email_code || !$user->two_factor_email_expires_at) {
            return false;
        }

        if (now()->greaterThan($user->two_factor_email_expires_at)) {
            return false;
        }

        return Hash::check($code, $user->two_factor_email_code);
    }

    protected function verifyRecoveryCode($user, $code)
    {
        $recoveryCodes = $user->two_factor_recovery_codes ?? [];
        
        foreach ($recoveryCodes as $index => $hashedCode) {
            if (Hash::check($code, $hashedCode)) {
                // Remove used recovery code
                unset($recoveryCodes[$index]);
                $user->update(['two_factor_recovery_codes' => array_values($recoveryCodes)]);
                return true;
            }
        }
        
        return false;
    }

    protected function sendEmailCode($user)
    {
        // Check if code already exists and is still valid
        if ($user->two_factor_email_code && 
            $user->two_factor_email_expires_at && 
            now()->lessThan($user->two_factor_email_expires_at)) {
            return;
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->update([
            'two_factor_email_code' => Hash::make($code),
            'two_factor_email_expires_at' => now()->addMinutes(10),
        ]);

        // Send email (you'll need to implement the Mailable)
        // Mail::to($user->email)->send(new TwoFactorCodeMail($code));
        
        // For now, we'll just display it (remove this in production)
        session(['debug_2fa_code' => $code]);
    }

    public function resendEmailCode()
    {
        $user = Auth::user();
        
        if (!$user || $user->two_factor_type !== 'email') {
            return redirect()->route('two-factor.challenge');
        }

        $this->sendEmailCode($user);
        
        return back()->with('status', 'Code resent successfully.');
    }

    protected function redirectToIntended()
    {
        $intended = session('2fa.intended', '/customer/home');
        session()->forget('2fa.intended');
        return redirect($intended);
    }
}