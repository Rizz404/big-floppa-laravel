<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition(): array
    {
        $breed = Breed::inRandomOrder()->first();
        $title = "Cute " . $breed->name;

        return [
            'seller_id' => User::inRandomOrder()->first()->id,
            'breed_id' => $breed->id,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->randomNumber(5),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 100000, 10000000),
            'birth_date' => $this->faker->dateTimeBetween('-2 years', '-2 months'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'location' => $this->faker->city(),
            'is_vaccinated' => $this->faker->boolean(80),
            'is_dewormed' => $this->faker->boolean(70),
            'status' => $this->faker->randomElement(['available', 'sold', 'archived']),
        ];
    }
}
