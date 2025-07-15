<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Seeder;

class BreedSeeder extends Seeder
{
    public function run(): void
    {
        $breeds = [
            ['name' => 'Persian', 'description' => 'A calm and affectionate long-haired breed that requires intensive grooming.'],
            ['name' => 'Siamese', 'description' => 'Very vocal, intelligent, and social. Loves to be the center of attention.'],
            ['name' => 'Maine Coon', 'description' => 'Known as the "gentle giant," friendly, and smart. Large in size.'],
            ['name' => 'Ragdoll', 'description' => 'Very docile and relaxed, often going limp like a doll when picked up.'],
            ['name' => 'British Shorthair', 'description' => 'Calm, independent, and not too demanding. Suitable for apartment living.'],
            ['name' => 'Domestic Shorthair', 'description' => 'Very diverse, generally strong, healthy, and possesses good hunting skills.'],
        ];

        foreach ($breeds as $breed) {
            $width = 640;
            $height = 480;

            $data = array_merge($breed, [
                'photo_url' => "https://picsum.photos/{$width}/{$height}?random=" . rand()
            ]);

            Breed::updateOrCreate(['name' => $breed['name']], $data);
        }
    }
}
