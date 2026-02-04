<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_credentials' => $user->credentials()->count(),
            'total_categories' => $user->categories()->count(),
            'favorites' => $user->credentials()->where('is_favorite', true)->count(),
        ];

        $credentials = $user->credentials()
            ->with('category')
            ->latest()
            ->paginate(10);

        $categories = $user->categories()->withCount('credentials')->get();

        return view('dashboard', compact('stats', 'credentials', 'categories'));
    }
}
