@extends('layouts.dashboard')

@section('title', 'Password Health')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Password Health Dashboard</h1>

    <!-- Health Score -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Overall Health Score</h2>
            <span class="text-4xl font-bold {{ $stats['score'] >= 80 ? 'text-green-600' : ($stats['score'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                {{ $stats['score'] }}%
            </span>
        </div>
        
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="h-4 rounded-full transition-all {{ $stats['score'] >= 80 ? 'bg-green-600' : ($stats['score'] >= 60 ? 'bg-yellow-600' : 'bg-red-600') }}" 
                 style="width: {{ $stats['score'] }}%"></div>
        </div>

        <p class="mt-4 text-gray-600">
            @if($stats['score'] >= 80)
                Excellent! Your passwords are in great shape.
            @elseif($stats['score'] >= 60)
                Good, but there's room for improvement.
            @else
                Your passwords need attention. Please review the issues below.
            @endif
        </p>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Passwords</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Weak Passwords</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['weak'] }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Reused Passwords</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['reused'] }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Old Passwords</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['old'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Issues -->
    @if(count($weakPasswords) > 0)
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">⚠️ Weak Passwords</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($weakPasswords as $item)
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item['credential']->website_name }}</p>
                        <p class="text-sm text-gray-600">{{ $item['credential']->username_email }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                            {{ ucfirst($item['strength']) }}
                        </span>
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
                            Fix Now
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if(count($reusedPasswords) > 0)
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">🔄 Reused Passwords</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($reusedPasswords as $item)
                <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item['credential']->website_name }}</p>
                        <p class="text-sm text-gray-600">Same password as {{ $item['reused_with']->website_name }}</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
                        Fix Now
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if(count($oldPasswords) > 0)
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">⏰ Old Passwords (90+ days)</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($oldPasswords as $item)
                <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $item['credential']->website_name }}</p>
                        <p class="text-sm text-gray-600">
                            Last updated {{ $item['age_days'] }} days ago
                            @if($item['credential']->password_updated_at)
                                ({{ $item['credential']->password_updated_at->format('M d, Y') }})
                            @else
                                (Created {{ $item['credential']->created_at->format('M d, Y') }})
                            @endif
                        </p>
                        <p class="text-xs text-yellow-700 mt-1">
                            ⚠️ Recommended to update passwords every 90 days
                        </p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium whitespace-nowrap ml-4">
                        Update Now
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if(count($weakPasswords) === 0 && count($reusedPasswords) === 0 && count($oldPasswords) === 0)
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">All Clear!</h3>
        <p class="text-gray-600">Your passwords are in excellent condition. Keep up the good work!</p>
    </div>
    @endif
</div>
@endsection
