<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // * Admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('177013'),
            'role' => "admin",
            'profile_picture_url' => "https://i.pinimg.com/736x/c6/ee/a1/c6eea122496fbe5aadc69231fddd5e2e.jpg"
        ]);

        // * User
        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user123'),
            'role' => "customer",
            'profile_picture_url' => "https://i.pinimg.com/736x/43/08/5c/43085cd7be90d65f3e16000038f57f6f.jpg"
        ]);

        // * Regular users
        User::factory(25)->create();
    }
}
