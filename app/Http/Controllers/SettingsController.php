<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function __construct(private ActivityLogService $activityLog)
    {
    }

    public function index()
    {
        $user = Auth::user();
        $activityLogs = $user->activityLogs()->latest()->take(6)->get();
        
        return view('settings', compact('user', 'activityLogs'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        Auth::user()->update($validated);

        $this->activityLog->log('profile_updated');

        return redirect()->route('settings')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols()],
        ]);

        // Check if new password is the same as current password
        if (Hash::check($validated['password'], Auth::user()->password)) {
            return redirect()->route('settings')
                ->withErrors(['password' => 'The new password is the same as the current password. Please use a different one.'])
                ->withInput();
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->activityLog->log('password_changed');

        return redirect()->route('settings')->with('success', 'Password updated successfully!');
    }
}
