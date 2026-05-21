<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $seller = User::factory()->create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'role' => 'seller',
            'password' => Hash::make('password'),
        ]);

        Product::create([
            'user_id' => $seller->id,
            'name' => 'Classic Jeat’aime Bag',
            'description' => 'A stylish and durable bag perfect for daily use.',
            'price' => 1299.00,
            'stock' => 12,
        ]);

        Product::create([
            'user_id' => $seller->id,
            'name' => 'Luxury Beauty Kit',
            'description' => 'Complete beauty set for a polished look.',
            'price' => 899.00,
            'stock' => 8,
        ]);
    }
}
