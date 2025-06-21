<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ServiceProvider;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('name');

        // Create a sample user
        $user = User::firstOrCreate([
            'email' => 'provider@example.com',
        ], [
            'name' => 'Fitness Pro',
            'password' => Hash::make('password'),
        ]);

        // Create service providers of different types
        $types = ['gym', 'nutrition', 'therapy', 'restaurant', 'store'];

        foreach ($types as $type) {
            $provider = ServiceProvider::firstOrCreate([
                'user_id' => $user->id,
                'type' => $type,
            ], [
                'about' => 'About this ' . ucfirst($type),
            ]);

            // Match category for the service
            $categoryMap = [
                'gym' => 'Gyms',
                'nutrition' => 'Nutrition',
                'therapy' => 'Therapy',
                'restaurant' => 'Restaurants',
                'store' => 'Store',
            ];

            $categoryName = $categoryMap[$type];
            $categoryId = $categories[$categoryName]->id;

            // Create a sample service
            Service::create([
                'provider_id' => $provider->id,
                'category_id' => $categoryId,
                'title' => ucfirst($type) . ' Service',
                'description' => 'Sample description for ' . $type,
                'price' => rand(20, 100),
                'image' => null, // You can update this later
            ]);
        }
    }
}
