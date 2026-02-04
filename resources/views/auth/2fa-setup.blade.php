@extends('layouts.dashboard')

@section('title', 'Setup 2FA')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Setup Two-Factor Authentication</h2>

        <div class="space-y-6">
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-blue-700">
                    <strong>Step 1:</strong> Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.)
                </p>
            </div>

            <div class="flex justify-center">
                <img src="{{ $qrCodeUrl }}" alt="QR Code" class="border-4 border-gray-200 rounded-lg">
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Or enter this code manually:</p>
                <code class="text-lg font-mono bg-white px-4 py-2 rounded border border-gray-300 block text-center">{{ $secret }}</code>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-blue-700">
                    <strong>Step 2:</strong> Enter the 6-digit code from your authenticator app to confirm
                </p>
            </div>

            <form method="POST" action="{{ route('2fa.confirm') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="secret" value="{{ $secret }}">

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Verification Code</label>
                    <input type="text" id="code" name="code" required maxlength="6" pattern="[0-9]{6}"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-center text-2xl tracking-widest @error('code') border-red-500 @enderror">
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Confirm & Enable 2FA
                    </button>
                    <a href="{{ route('settings') }}" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
