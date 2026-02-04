<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct(private ActivityLogService $activityLog)
    {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:7'],
        ]);

        $category = Auth::user()->categories()->create([
            'name' => $validated['name'],
            'color' => $validated['color'] ?? '#4A90E2',
        ]);

        $this->activityLog->log('category_created', 'Category', $category->id);

        return redirect()->route('dashboard')->with('success', 'Category created successfully!');
    }
}
