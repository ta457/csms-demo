<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin = User::create([
            'username' => 'admin',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '11111111',
            'role' => 1
        ]);

        $manager = User::create([
            'username' => 'manager',
            'name' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => '11111111',
            'role' => 2
        ]);

        $employee = User::create([
            'username' => 'employee',
            'name' => 'employee',
            'email' => 'employee@gmail.com',
            'password' => '11111111',
            'role' => 3
        ]);
    }
}
