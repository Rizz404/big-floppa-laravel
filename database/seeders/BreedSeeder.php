<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Seeder;

class BreedSeeder extends Seeder
{
    public function run(): void
    {
        $breeds = [
            ['name' => 'Persia', 'description' => 'Ras berbulu panjang yang tenang dan penyayang, butuh perawatan bulu intensif.'],
            ['name' => 'Siam (Siamese)', 'description' => 'Sangat vokal, cerdas, dan sosial. Suka menjadi pusat perhatian.'],
            ['name' => 'Maine Coon', 'description' => 'Dikenal sebagai "raksasa lembut", ramah, dan pintar. Berukuran besar.'],
            ['name' => 'Ragdoll', 'description' => 'Sangat jinak dan santai, seringkali lemas seperti boneka saat diangkat.'],
            ['name' => 'British Shorthair', 'description' => 'Tenang, mandiri, dan tidak terlalu menuntut. Cocok untuk apartemen.'],
            ['name' => 'Domestik (Kampung)', 'description' => 'Sangat beragam, umumnya kuat, sehat, dan punya kemampuan berburu yang baik.'],
        ];

        foreach ($breeds as $breed) {
            Breed::updateOrCreate(['name' => $breed['name']], $breed);
        }
    }
}
