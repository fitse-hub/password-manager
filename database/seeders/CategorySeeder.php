<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaultCategories = [
            ['name' => 'Work', 'color' => '#4A90E2', 'is_default' => true],
            ['name' => 'Personal', 'color' => '#50E3C2', 'is_default' => true],
            ['name' => 'Banking', 'color' => '#F5A623', 'is_default' => true],
            ['name' => 'Social', 'color' => '#BD10E0', 'is_default' => true],
        ];

        // Get all users
        $users = User::all();

        foreach ($users as $user) {
            foreach ($defaultCategories as $category) {
                // Check if category already exists for this user
                $exists = Category::where('user_id', $user->id)
                    ->where('name', $category['name'])
                    ->exists();

                if (!$exists) {
                    Category::create([
                        'user_id' => $user->id,
                        'name' => $category['name'],
                        'color' => $category['color'],
                        'is_default' => $category['is_default'],
                    ]);
                }
            }
        }
    }
}
