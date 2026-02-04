@extends('layouts.dashboard')

@section('title', '2FA Recovery Codes')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Recovery Codes</h2>

        <div class="space-y-6">
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                <p class="text-yellow-700">
                    <strong>Important:</strong> Save these recovery codes in a safe place. Each code can only be used once.
                </p>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
                <div class="grid grid-cols-2 gap-4">
                    @foreach($recoveryCodes as $code)
                        <code class="text-lg font-mono bg-white px-4 py-2 rounded border border-gray-300 text-center">{{ $code }}</code>
                    @endforeach
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-blue-700">
                    <strong>How to use:</strong> If you lose access to your authenticator app, you can use one of these codes instead of the 6-digit code.
                </p>
            </div>

            <div class="flex space-x-3">
                <button onclick="printCodes()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Print Codes
                </button>
                <button onclick="copyCodes()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Copy to Clipboard
                </button>
                <a href="{{ route('settings') }}" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-center">
                    Done
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function printCodes() {
    window.print();
}

function copyCodes() {
    const codes = @json($recoveryCodes);
    const text = codes.join('\n');
    navigator.clipboard.writeText(text).then(() => {
        alert('Recovery codes copied to clipboard!');
    });
}
</script>
@endsection
