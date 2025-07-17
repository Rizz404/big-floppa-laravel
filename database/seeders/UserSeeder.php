<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cart;
use App\Models\UserProfile;
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
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('177013'),
            'role' => "admin",
            'profile_picture_url' => "https://i.pinimg.com/736x/c6/ee/a1/c6eea122496fbe5aadc69231fddd5e2e.jpg"
        ]);

        $this->createRelatedModels($admin);

        // * Customer user
        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('177013'),
            'role' => "customer",
            'profile_picture_url' => "https://i.pinimg.com/736x/43/08/5c/43085cd7be90d65f3e16000038f57f6f.jpg"
        ]);

        $this->createRelatedModels($user);

        // * Regular users
        User::factory(25)->create()->each(function ($user) {
            $this->createRelatedModels($user);
        });
    }

    /**
     * Create related Cart and UserProfile for a user.
     */
    private function createRelatedModels(User $user): void
    {
        Cart::create([
            'user_id' => $user->id,
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'phone_number' => fake()->phoneNumber(),
            'age' => fake()->numberBetween(16, 5000),
        ]);
    }
}
