<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthController extends Controller
{
    public function __construct(
        private ActivityLogService $activityLog,
        private Google2FA $google2fa
    ) {
    }

    public function enable()
    {
        $user = Auth::user();

        if ($user->two_factor_enabled) {
            return back()->with('error', '2FA is already enabled');
        }

        $secret = $this->google2fa->generateSecretKey();
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('auth.2fa-setup', [
            'secret' => $secret,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'secret' => 'required|string',
            'code' => 'required|numeric',
        ]);

        $user = Auth::user();
        $valid = $this->google2fa->verifyKey($request->secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid verification code']);
        }

        // Generate recovery codes
        $recoveryCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $recoveryCodes[] = strtoupper(substr(md5(random_bytes(10)), 0, 10));
        }

        $user->update([
            'two_factor_enabled' => true,
            'two_factor_secret' => encrypt($request->secret),
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ]);

        $this->activityLog->log('2fa_enabled');

        return view('auth.2fa-recovery-codes', ['recoveryCodes' => $recoveryCodes]);
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = Auth::user();

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ]);

        $this->activityLog->log('2fa_disabled');

        return back()->with('success', '2FA has been disabled');
    }

    public function verify()
    {
        // Check if there's a pending 2FA verification
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.2fa-verify');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        // Get the user ID from session
        $userId = session('2fa_user_id');
        
        if (!$userId) {
            return redirect()->route('login')->withErrors(['code' => 'Session expired. Please login again.']);
        }

        $user = \App\Models\User::find($userId);

        if (!$user || !$user->two_factor_enabled) {
            session()->forget(['2fa_user_id', '2fa_remember']);
            return redirect()->route('login');
        }

        $secret = decrypt($user->two_factor_secret);

        // Check if it's a recovery code
        if (strlen($request->code) === 10) {
            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            
            if (in_array(strtoupper($request->code), $recoveryCodes)) {
                // Remove used recovery code
                $recoveryCodes = array_diff($recoveryCodes, [strtoupper($request->code)]);
                $user->update([
                    'two_factor_recovery_codes' => encrypt(json_encode(array_values($recoveryCodes))),
                ]);

        // Login the user
        $remember = session('2fa_remember', false);
        Auth::login($user, $remember);
        
        // Regenerate session for security
        request()->session()->regenerate();
        
        // Update last login
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        // Clear 2FA session data
        session()->forget(['2fa_user_id', '2fa_remember']);

        $this->activityLog->log('2fa_verified_recovery');

        return redirect()->intended('dashboard')->with('success', 'Login successful!');
            }
        }

        // Verify TOTP code
        $valid = $this->google2fa->verifyKey($secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid verification code']);
        }

        // Login the user
        $remember = session('2fa_remember', false);
        Auth::login($user, $remember);
        
        // Regenerate session for security
        request()->session()->regenerate();
        
        // Update last login
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);

        // Clear 2FA session data
        session()->forget(['2fa_user_id', '2fa_remember']);

        $this->activityLog->log('2fa_verified');

        return redirect()->intended('dashboard')->with('success', 'Login successful!');
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = Auth::user();

        if (!$user->two_factor_enabled) {
            return back()->with('error', '2FA is not enabled');
        }

        $recoveryCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $recoveryCodes[] = strtoupper(substr(md5(random_bytes(10)), 0, 10));
        }

        $user->update([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ]);

        $this->activityLog->log('2fa_recovery_codes_regenerated');

        return view('auth.2fa-recovery-codes', ['recoveryCodes' => $recoveryCodes]);
    }
}
