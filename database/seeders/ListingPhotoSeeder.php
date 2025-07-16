<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\ListingPhoto;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ListingPhotoSeeder extends Seeder
{
    public function run(): void
    {
        if (Listing::count() === 0) {
            $this->command->info('Tidak ada listing untuk ditambahkan foto. Silakan jalankan ListingSeeder terlebih dahulu.');
            return;
        }

        $faker = Faker::create();
        $listings = Listing::all();

        foreach ($listings as $listing) {
            // * Hapus foto lama jika ada, untuk menghindari duplikasi saat re-seed
            $listing->photos()->delete();

            // * Buat 1 foto utama
            ListingPhoto::factory()->create([
                'listing_id' => $listing->id,
                'is_primary' => true,
            ]);

            // * Buat 2-4 foto tambahan
            $additionalPhotos = $faker->numberBetween(2, 4);
            ListingPhoto::factory($additionalPhotos)->create([
                'listing_id' => $listing->id,
                'is_primary' => false,
            ]);
        }
    }
}
