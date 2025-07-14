<?php

namespace Database\Seeders;

use App\Models\Criterion;
use Illuminate\Database\Seeder;

class CriterionSeeder extends Seeder
{
    public function run(): void
    {
        $criteria = [
            ['name' => 'Tingkat Perawatan', 'type' => 'cost', 'description' => 'Seberapa sering butuh grooming, mandi, dan perhatian khusus.'],
            ['name' => 'Biaya Perawatan', 'type' => 'cost', 'description' => 'Estimasi biaya bulanan untuk makanan, pasir, dan kesehatan.'],
            ['name' => 'Tingkat Keaktifan', 'type' => 'benefit', 'description' => 'Seberapa suka bermain dan butuh ruang gerak.'],
            ['name' => 'Sifat Ramah (Anak & Hewan Lain)', 'type' => 'benefit', 'description' => 'Seberapa mudah bergaul dengan anak-anak dan hewan peliharaan lain.'],
            ['name' => 'Kebutuhan Ruang', 'type' => 'cost', 'description' => 'Semakin tinggi skor, semakin butuh apartemen/rumah yang luas.'],
            ['name' => 'Kecerdasan', 'type' => 'benefit', 'description' => 'Seberapa mudah dilatih dan beradaptasi.'],
        ];

        foreach ($criteria as $criterion) {
            // * Gunakan updateOrCreate agar seeder bisa dijalankan berkali-kali tanpa duplikasi
            Criterion::updateOrCreate(['name' => $criterion['name']], $criterion);
        }
    }
}
