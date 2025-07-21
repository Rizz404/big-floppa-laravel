<?php

namespace Database\Factories;

use App\Models\ListingPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListingPhotoFactory extends Factory
{
    protected $model = ListingPhoto::class;

    public function definition(): array
    {
        return [
            'path' => "https://placekitten.com/400/400",
            'is_primary' => false,
            'caption' => $this->faker->sentence(6),
        ];
    }
}
