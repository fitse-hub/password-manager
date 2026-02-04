@extends('layouts.dashboard')

@section('title', 'Export Data')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Export Your Data</h2>

        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
            <div class="flex">
                <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <p class="text-yellow-700 font-medium">Security Warning</p>
                    <p class="text-yellow-600 text-sm mt-1">
                        Anyone with access to this file and your export password (if set) can view all your credentials. 
                        Store it securely and delete it after use.
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('export.download') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                <div class="space-y-2">
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="format" value="json" checked class="mr-3">
                        <div>
                            <p class="font-medium text-gray-900">JSON</p>
                            <p class="text-sm text-gray-600">Structured format, best for backup and re-import</p>
                        </div>
                    </label>
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="format" value="csv" class="mr-3">
                        <div>
                            <p class="font-medium text-gray-900">CSV</p>
                            <p class="text-sm text-gray-600">Spreadsheet format, compatible with Excel</p>
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Your Account Password (Required)</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Confirm your identity before exporting</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="export_password" class="block text-sm font-medium text-gray-700">Export Password (Optional but Recommended)</label>
                <input type="password" id="export_password" name="export_password" minlength="12"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">
                    Add an extra layer of protection. The exported file will be encrypted with this password. 
                    <strong>Remember this password!</strong> You'll need it to decrypt the file.
                </p>
                <p class="mt-2 text-xs text-amber-600">
                    <strong>Note:</strong> If using HTTP (not HTTPS), your browser may show a security warning. 
                    Click "Download insecure file" or "Keep" to proceed with the download.
                </p>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-blue-700 text-sm">
                    <strong>What's included:</strong> All your credentials (website names, usernames, passwords, notes, categories) 
                    will be exported in plain text (or encrypted if you set an export password).
                </p>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    Export Data
                </button>
                <a href="{{ route('settings') }}" class="flex-1 bg-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300 transition text-center font-medium">
                    Cancel
                </a>
            </div>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="font-medium text-gray-900 mb-2">Security Best Practices</h3>
            <ul class="text-sm text-gray-600 space-y-1">
                <li>✓ Always use an export password for encryption</li>
                <li>✓ Store the exported file in a secure location</li>
                <li>✓ Delete the file after you're done with it</li>
                <li>✓ Never share the file or export password</li>
                <li>✓ Use a strong, unique export password</li>
            </ul>
        </div>
    </div>
</div>
@endsection
