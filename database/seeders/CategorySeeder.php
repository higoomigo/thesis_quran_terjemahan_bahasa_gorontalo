<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tafsir & Makna',
                'description' => 'Diskusi seputar penafsiran dan makna mendalam dari sebuah ayat.',
            ],
            [
                'name' => 'Tata Bahasa Gorontalo',
                'description' => 'Bahas struktur kalimat, imbuhan, dan aturan bahasa Gorontalo.',
            ],
            [
                'name' => 'Kosakata Serapan',
                'description' => 'Diskusi tentang padanan kata yang tepat dari bahasa Arab ke bahasa Gorontalo.',
            ],
            [
                'name' => 'Saran & Masukan Terjemahan',
                'description' => 'Punya ide terjemahan yang lebih pas? Sampaikan di sini.',
            ],
            [
                'name' => 'Diskusi Umum',
                'description' => 'Obrolan santai dan umum seputar proyek Qur\'an Gorontalo.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}