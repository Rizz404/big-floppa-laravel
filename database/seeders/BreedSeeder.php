<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class BreedSeeder extends Seeder
{
    public function run(): void
    {
        $breeds = [
            [
                'name' => 'Persian',
                'description' => 'A calm and affectionate long-haired breed that requires intensive grooming.',
                'origin_country' => 'Iran'
            ],
            [
                'name' => 'Siamese',
                'description' => 'Very vocal, intelligent, and social. Loves to be the center of attention.',
                'origin_country' => 'Thailand'
            ],
            [
                'name' => 'Maine Coon',
                'description' => 'Known as the "gentle giant," friendly, and smart. Large in size.',
                'origin_country' => 'United States'
            ],
            [
                'name' => 'Ragdoll',
                'description' => 'Very docile and relaxed, often going limp like a doll when picked up.',
                'origin_country' => 'United States'
            ],
            [
                'name' => 'British Shorthair',
                'description' => 'Calm, independent, and not too demanding. Suitable for apartment living.',
                'origin_country' => 'United Kingdom'
            ],
            [
                'name' => 'Domestic Shorthair',
                'description' => 'Very diverse, generally strong, healthy, and possesses good hunting skills.',
                'origin_country' => 'Varies (Not a standardized breed)'
            ],
        ];

        if (!env('CAT_API_KEY')) {
            $this->command->error('CAT_API_KEY tidak ditemukan di file .env. Seeder dihentikan.');
            return;
        }

        $this->command->info('Mengambil URL gambar dari TheCatAPI...');

        $response = Http::withHeaders([
            'x-api-key' => env('CAT_API_KEY')
        ])->get('https://api.thecatapi.com/v1/images/search', [
            'limit' => 100,
            'mime_types' => 'jpg,png',
            'size' => 'med',
        ]);

        if ($response->failed()) {
            $this->command->error('Gagal mengambil data dari TheCatAPI. Seeder dihentikan.');
            return;
        }

        $imagePaths = collect($response->json())->pluck('url')->toArray();


        foreach ($breeds as $breed) {
            $data = array_merge($breed, [
                'photo_url' => fake()->randomElement($imagePaths)
            ]);

            Breed::updateOrCreate(['name' => $breed['name']], $data);
        }
    }
}
