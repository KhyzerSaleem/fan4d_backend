<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Review::where('id', 1)->first();
        if (!$exists_data) {
            Review::updateOrCreate([
                'id' => 1,
                'title_ar' => 'عمر محمد',
                'title_en' => 'Omar Mohamed',
                'job_name_ar' => 'مدير تسويق',
                'job_name_en' => 'Marketing Manager',
                'desc_ar' => 'خدمتكم في الطباعة والتغليف ممتازة، المنتجات وصلت بشكل رائع، والمواد المستخدمة عالية الجودة، وأنا سعيد جدًا بالتعامل معكم.',
                'desc_en' => 'Your printing and packaging service is excellent, the products arrived in great condition, the materials used are of high quality, and I am very happy to deal with you.',
                'image' => 'Review1.png',
                'is_active' => 1,
            ]);
            Review::updateOrCreate([
                'id' => 2,
                'title_ar' => 'عمر محمد',
                'title_en' => 'Omar Mohamed',
                'job_name_ar' => 'مدير تسويق',
                'job_name_en' => 'Marketing Manager',
                'desc_ar' => 'خدمتكم في الطباعة والتغليف ممتازة، المنتجات وصلت بشكل رائع، والمواد المستخدمة عالية الجودة، وأنا سعيد جدًا بالتعامل معكم.',
                'desc_en' => 'Your printing and packaging service is excellent, the products arrived in great condition, the materials used are of high quality, and I am very happy to deal with you.',
                'image' => 'Review1.png',
                'is_active' => 1,
            ]);
            Review::updateOrCreate([
                'id' => 3,
                'title_ar' => 'عمر محمد',
                'title_en' => 'Omar Mohamed',
                'job_name_ar' => 'مدير تسويق',
                'job_name_en' => 'Marketing Manager',
                'desc_ar' => 'خدمتكم في الطباعة والتغليف ممتازة، المنتجات وصلت بشكل رائع، والمواد المستخدمة عالية الجودة، وأنا سعيد جدًا بالتعامل معكم.',
                'desc_en' => 'Your printing and packaging service is excellent, the products arrived in great condition, the materials used are of high quality, and I am very happy to deal with you.',
                'image' => 'Review1.png',
                'is_active' => 1,
            ]);
        }

    }
}
