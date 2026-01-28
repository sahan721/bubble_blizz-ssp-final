<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\AdminUserSeeder;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed products
        $this->call(ProductSeeder::class);

        // Seed admin user (login credentials)
        $this->call(AdminUserSeeder::class);

        // OPTIONAL: Test user
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
