<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\ListingPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ListingPhotoSeeder extends Seeder
{
    public function run(): void
    {
        if (Listing::count() === 0) {
            $this->command->info('Tidak ada listing untuk ditambahkan foto. Silakan jalankan ListingSeeder terlebih dahulu.');
            return;
        }

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
        $listings = Listing::all();

        foreach ($listings as $listing) {
            $listing->photos()->delete();

            ListingPhoto::factory()->create([
                'listing_id' => $listing->id,
                'is_primary' => true,
                'path' => fake()->randomElement($imagePaths),
            ]);

            $additionalPhotosCount = fake()->numberBetween(2, 4);
            ListingPhoto::factory($additionalPhotosCount)
                ->state(new Sequence(
                    fn(Sequence $sequence) => ['path' => fake()->randomElement($imagePaths)],
                ))
                ->create([
                    'listing_id' => $listing->id,
                    'is_primary' => false,
                ]);
        }

        $this->command->info('Seeding foto untuk listing telah selesai.');
    }
}
