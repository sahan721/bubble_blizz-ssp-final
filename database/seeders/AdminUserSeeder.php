<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bubbleblizz.com'],
            [
                'name' => 'BubbleBlizz Admin',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'status' => 'active',
                'phone' => null,
                'address' => null,
            ]
        );
    }
}
