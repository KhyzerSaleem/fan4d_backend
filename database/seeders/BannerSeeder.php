<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Banner::where('id', 1)->first();
        if (!$exists_data) {
            Banner::updateOrCreate([
                'id' => 1,
                'title_ar' => 'خصومات مميزة على الطباعة',
                'title_en' => 'Special discounts on printing',
                'desc_ar' => 'جودة، سرعة، أسعار رائعة',
                'desc_en' => 'Quality, speed, great prices.',
                'image' => 'Banner1.png',
                'is_active' => 1,
            ]);
            Banner::updateOrCreate([
                'id' => 2,
                'title_ar' => 'خصومات مميزة على الطباعة',
                'title_en' => 'Special discounts on printing',
                'desc_ar' => 'جودة، سرعة، أسعار رائعة',
                'desc_en' => 'Quality, speed, great prices.',
                'image' => 'Banner1.png',
                'is_active' => 1,
            ]);
            Banner::updateOrCreate([
                'id' => 3,
                'title_ar' => 'خصومات مميزة على الطباعة',
                'title_en' => 'Special discounts on printing',
                'desc_ar' => 'جودة، سرعة، أسعار رائعة',
                'desc_en' => 'Quality, speed, great prices.',
                'image' => 'Banner1.png',
                'is_active' => 1,
            ]);

        }

    }
}
