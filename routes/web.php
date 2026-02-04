<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PasswordGeneratorController;
use App\Http\Controllers\PasswordHealthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TwoFactorAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset
    Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// 2FA Verification (accessible without full auth)
Route::get('/2fa/verify', [TwoFactorAuthController::class, 'verify'])->name('2fa.verify')->middleware('guest');
Route::post('/2fa/verify', [TwoFactorAuthController::class, 'verifyCode'])->middleware('guest');

// Email Verification
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('signed');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->name('verification.send');
});

Route::middleware(['auth', '2fa.verified'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Credentials
    Route::post('/credentials', [CredentialController::class, 'store'])->name('credentials.store');
    Route::put('/credentials/{credential}', [CredentialController::class, 'update'])->name('credentials.update');
    Route::delete('/credentials/{credential}', [CredentialController::class, 'destroy'])->name('credentials.destroy');
    Route::get('/credentials/{credential}/decrypt', [CredentialController::class, 'decrypt'])->name('credentials.decrypt');
    Route::post('/credentials/{credential}/favorite', [CredentialController::class, 'toggleFavorite'])->name('credentials.favorite');
    
    // Categories
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    
    // Password Generator
    Route::post('/password/generate', [PasswordGeneratorController::class, 'generate'])->name('password.generate');
    
    // Password Health
    Route::get('/password-health', [PasswordHealthController::class, 'index'])->name('password.health');
    
    // Two-Factor Authentication
    Route::get('/2fa/enable', [TwoFactorAuthController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/confirm', [TwoFactorAuthController::class, 'confirm'])->name('2fa.confirm');
    Route::post('/2fa/disable', [TwoFactorAuthController::class, 'disable'])->name('2fa.disable');
    Route::post('/2fa/recovery-codes', [TwoFactorAuthController::class, 'regenerateRecoveryCodes'])->name('2fa.recovery.regenerate');
    
    // Export
    Route::get('/export', [ExportController::class, 'showForm'])->name('export');
    Route::post('/export', [ExportController::class, 'export'])->name('export.download');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
});
