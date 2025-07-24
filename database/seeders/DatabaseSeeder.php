<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@hkbp.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        // Create Bendahara User
        \App\Models\User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@hkbp.com',
            'password' => bcrypt('bendahara123'),
            'role' => 'bendahara'
        ]);

        // Create Pengurus User
        \App\Models\User::create([
            'name' => 'Pengurus',
            'email' => 'pengurus@hkbp.com',
            'password' => bcrypt('pengurus123'),
            'role' => 'pengurus'
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
