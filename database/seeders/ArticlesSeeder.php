<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\MedicalInstruction;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Article::where('id', 1)->first();
        if (!$exists_data) {
            Article::updateOrCreate([
                'id' => 1,
                'title_ar' => 'ترطيب الجسم بانتظام',
                'title_en' => 'Hydrate Regularly',
                'desc_ar' => 'اشرب الماء للحصول على الأداء الأمثل للجسم وتوازن الترطيب',
                'desc_en' => 'Drink water for optimal bodily function and hydration balance',
                'image' => 'articles1.png',
                'published_at' => '2024-10-01',
                'is_active' => 1,
            ]);

            Article::updateOrCreate([
                'id' => 2,
                'title_ar' => 'ترطيب الجسم بانتظام',
                'title_en' => 'Hydrate Regularly',
                'desc_ar' => 'اشرب الماء للحصول على الأداء الأمثل للجسم وتوازن الترطيب',
                'desc_en' => 'Drink water for optimal bodily function and hydration balance',
                'image' => 'articles2.png',
                'published_at' => '2024-10-03',
                'is_active' => 1,
            ]);

            Article::updateOrCreate([
                'id' => 3,
                'title_ar' => 'ترطيب الجسم بانتظام',
                'title_en' => 'Hydrate Regularly',
                'desc_ar' => 'اشرب الماء للحصول على الأداء الأمثل للجسم وتوازن الترطيب',
                'desc_en' => 'Drink water for optimal bodily function and hydration balance',
                'image' => 'articles3.png',
                'published_at' => '2024-10-04',
                'is_active' => 1,
            ]);


        }

    }
}
