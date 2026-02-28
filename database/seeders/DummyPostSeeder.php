<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DummyPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ensure we have some categories
        $categories = [
            'Berita Sekolah',
            'Prestasi Siswa',
            'Agenda Kegiatan',
            'Tips & Artikel',
            'Pengumuman'
        ];

        $categoryIds = [];
        foreach ($categories as $catName) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName, 'description' => $faker->sentence()]
            );
            $categoryIds[] = $category->id;
        }

        // Generate 15 dummy posts
        for ($i = 0; $i < 15; $i++) {
            $title = $faker->sentence(rand(6, 10));
            Post::create([
                'title' => $title,
                'subtitle' => $faker->sentence(),
                'slug' => Str::slug($title) . '-' . rand(100, 999),
                'content' => '<div>' . implode('</div><div>', $faker->paragraphs(rand(3, 6))) . '</div>',
                'description' => $faker->text(150),
                'published_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'category_id' => $faker->randomElement($categoryIds),
                'seo_title' => $title,
                'seo_description' => $faker->text(100),
            ]);
        }
    }
}
