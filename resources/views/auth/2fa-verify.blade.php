@extends('layouts.app')

@section('title', '2FA Verification')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-lg">
        <div>
            <div class="flex justify-center">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">Two-Factor Authentication</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Enter the 6-digit code from your authenticator app
            </p>
        </div>

        <form class="mt-8 space-y-6" method="POST" action="{{ route('2fa.verify') }}">
            @csrf

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                <input type="text" id="code" name="code" required maxlength="10" autofocus
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-center text-2xl tracking-widest @error('code') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500 text-center">Or enter a recovery code</p>
                @error('code')
                    <p class="mt-1 text-sm text-red-600 text-center">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Verify
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
