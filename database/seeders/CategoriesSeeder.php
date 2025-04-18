<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $exists_data = Category::where('id', 1)->first();
        if (!$exists_data) {
            Category::create([
                'title_ar' => 'لوحات الاكريليك',
                'title_en' => 'Acrylic panels',
                'desc_ar' => 'الوصف بالعربية',
                'desc_en' => 'description in english',
                'image' => 'category1.png',
                'is_active' => 1,
            ]);

            Category::create([
                'title_ar' => 'منتجات حسب المناسبة',
                'title_en' => 'Products by Occasion',
                'desc_ar' => 'الوصف بالعربية',
                'desc_en' => 'description in english',
                'is_active' => 1,
            ]);

            Category::create([
                'title_ar' => 'منتجات الشركات',
                'title_en' => 'Corporate Products',
                'desc_ar' => 'الوصف بالعربية',
                'desc_en' => 'description in english',
                'image' => 'category1.png',
                'is_active' => 1,
            ]);

            Category::create([
                'title_ar' => 'زخرفه',
                'title_en' => 'decor',
                'desc_ar' => 'الوصف بالعربية',
                'desc_en' => 'description in english',
                'image' => 'category1.png',
                'type' => 'not_printing',
                'is_active' => 1,
            ]);
            Category::create([
                'title_ar' => 'التغليف والصناديق',
                'title_en' => 'Packaging and boxes',
                'desc_ar' => 'الوصف بالعربية',
                'desc_en' => 'description in english',
                'image' => 'category1.png',
                'type' => 'not_printing',
                'is_active' => 1,
            ]);
        }
    }
}
