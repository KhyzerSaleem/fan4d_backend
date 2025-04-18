<?php

namespace Database\Seeders;

use App\Models\Step;
use Illuminate\Database\Seeder;

class StepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Step::where('id', 1)->first();
        if (!$exists_data) {
            Step::updateOrCreate([
                'id' => 1,
                'number' => '01',
                'title_ar' => 'اختر المنتج الأنسب لك',
                'title_en' => 'Choose the product that suits you best',
                'desc_ar' => 'تصفح منتجاتنا المتنوعة واختر الأنسب لك بناءً على احتياجاتك واهتماماتك لضمان الحصول على منتج مميز يتناسب مع رؤيتك.',
                'desc_en' => 'Browse our diverse products and choose the most suitable one for you based on your needs and interests to ensure you get a distinctive product that matches your vision.',
                'image' => 'Step1.png',
            ]);
            Step::updateOrCreate([
                'id' => 2,
                'number' => '02',
                'title_ar' => 'اختر المنتج الأنسب لك',
                'title_en' => 'Choose the product that suits you best',
                'desc_ar' => 'تصفح منتجاتنا المتنوعة واختر الأنسب لك بناءً على احتياجاتك واهتماماتك لضمان الحصول على منتج مميز يتناسب مع رؤيتك.',
                'desc_en' => 'Browse our diverse products and choose the most suitable one for you based on your needs and interests to ensure you get a distinctive product that matches your vision.',
                'image' => 'Step1.png',
            ]);
            Step::updateOrCreate([
                'id' => 3,
                'number' => '03',
                'title_ar' => 'اختر المنتج الأنسب لك',
                'title_en' => 'Choose the product that suits you best',
                'desc_ar' => 'تصفح منتجاتنا المتنوعة واختر الأنسب لك بناءً على احتياجاتك واهتماماتك لضمان الحصول على منتج مميز يتناسب مع رؤيتك.',
                'desc_en' => 'Browse our diverse products and choose the most suitable one for you based on your needs and interests to ensure you get a distinctive product that matches your vision.',
                'image' => 'Step1.png',
            ]);
            Step::updateOrCreate([
                'id' => 4,
                'number' => '04',
                'title_ar' => 'اختر المنتج الأنسب لك',
                'title_en' => 'Choose the product that suits you best',
                'desc_ar' => 'تصفح منتجاتنا المتنوعة واختر الأنسب لك بناءً على احتياجاتك واهتماماتك لضمان الحصول على منتج مميز يتناسب مع رؤيتك.',
                'desc_en' => 'Browse our diverse products and choose the most suitable one for you based on your needs and interests to ensure you get a distinctive product that matches your vision.',
                'image' => 'Step1.png',
            ]);

        }

    }
}
