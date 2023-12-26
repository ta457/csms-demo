<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Provider;
use App\Models\Product;
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

        $category0 = Category::create([
            'name' => 'Default category',
            'description' => 'All products in deleted categories go here'
        ]);
        $category1 = Category::create([
            'name' => 'Product type A',
            'description' => 'This is a product category'
        ]);
        $provider0 = Provider::create([
            'name' => 'Default provider',
            'description' => 'All products in deleted providers go here',
            'phone' => '0000000000',
            'email' => 'defaultprovider@gmail.com',
            'address' => 'Default address'
        ]);
        $provider1 = Provider::create([
            'name' => 'Provider 1',
            'description' => 'Provider of product A, B',
            'phone' => '0000000001',
            'email' => 'providerone@gmail.com',
            'address' => 'City A, Distric B, Street C'
        ]);
            Product::create([
                'name' => 'Product 1',
                'description' => 'This is a product',
                'price' => '20000',
                'quantity' => '10',
                'category_id' => $category1->id,
                'provider_id' => $provider0->id
            ]);
            Product::create([
                'name' => 'Product 2',
                'description' => 'This is a product',
                'price' => '30000',
                'quantity' => '20',
                'category_id' => $category1->id,
                'provider_id' => $provider0->id
            ]);

        $category2 = Category::create([
            'name' => 'Product type B',
            'description' => 'This is a product category'
        ]);
            Product::create([
                'name' => 'Product 3',
                'description' => 'This is a product',
                'price' => '20000',
                'quantity' => '30',
                'category_id' => $category2->id,
                'provider_id' => $provider0->id
            ]);
            Product::create([
                'name' => 'Product 4',
                'description' => 'This is a product',
                'price' => '30000',
                'quantity' => '40',
                'category_id' => $category2->id,
                'provider_id' => $provider0->id
            ]);
    }
}
