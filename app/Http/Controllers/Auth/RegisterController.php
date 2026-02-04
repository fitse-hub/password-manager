<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __construct(private ActivityLogService $activityLog)
    {
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        // Create default categories for the user
        $defaultCategories = [
            ['name' => 'Work', 'color' => '#4A90E2', 'is_default' => true],
            ['name' => 'Personal', 'color' => '#50E3C2', 'is_default' => true],
            ['name' => 'Banking', 'color' => '#F5A623', 'is_default' => true],
            ['name' => 'Social', 'color' => '#BD10E0', 'is_default' => true],
        ];

        foreach ($defaultCategories as $category) {
            $user->categories()->create($category);
        }

        Auth::login($user);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        $this->activityLog->log('user_registered');

        return redirect()->route('verification.notice')->with('success', 'Account created! Please verify your email address.');
    }
}
