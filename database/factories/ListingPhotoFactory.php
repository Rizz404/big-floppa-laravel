<?php

namespace Database\Factories;

use App\Models\ListingPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListingPhotoFactory extends Factory
{
    protected $model = ListingPhoto::class;

    public function definition(): array
    {
        $imageServices = [
            'https://picsum.photos/640/480',
            'https://loremflickr.com/640/480/cat',
        ];

        return [
            'path' => $this->faker->randomElement($imageServices),
            'is_primary' => false,
            'caption' => $this->faker->sentence(6),
        ];
    }
}
