<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SlidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Slider::where('id', 1)->first();
        if (!$exists_data) {
            Slider::updateOrCreate([
                'id' => 1,
                'title_ar' => 'خدمات طباعة وتصميم وتغليف بجودة استثنائية لكل منتج',
                'title_en' => 'Exceptional quality printing, design and packaging services for every product.',
                'desc_ar' => 'في فن، نقدم حلول طباعة وتصميم مخصصة باستخدام مواد عالية الجودة وتقنيات مبتكرة لنساعدك في تحقيق هوية تجارية استثنائية بكل تفاصيلها.',
                'desc_en' => 'At Fan, we provide customized printing and design solutions using high-quality materials and innovative techniques to help you achieve an exceptional brand identity in every detail.',
                'image' => 'slider1.png',
                'is_active' => 1,
            ]);
            Slider::updateOrCreate([
                'id' => 2,
                'title_ar' => 'خدمات طباعة وتصميم وتغليف بجودة استثنائية لكل منتج',
                'title_en' => 'Exceptional quality printing, design and packaging services for every product.',
                'desc_ar' => 'في فن، نقدم حلول طباعة وتصميم مخصصة باستخدام مواد عالية الجودة وتقنيات مبتكرة لنساعدك في تحقيق هوية تجارية استثنائية بكل تفاصيلها.',
                'desc_en' => 'At Fan, we provide customized printing and design solutions using high-quality materials and innovative techniques to help you achieve an exceptional brand identity in every detail.',
                'image' => 'slider2.png',
                'is_active' => 1,
            ]);
            Slider::updateOrCreate([
                'id' => 3,
                'title_ar' => 'خدمات طباعة وتصميم وتغليف بجودة استثنائية لكل منتج',
                'title_en' => 'Exceptional quality printing, design and packaging services for every product.',
                'desc_ar' => 'في فن، نقدم حلول طباعة وتصميم مخصصة باستخدام مواد عالية الجودة وتقنيات مبتكرة لنساعدك في تحقيق هوية تجارية استثنائية بكل تفاصيلها.',
                'desc_en' => 'At Fan, we provide customized printing and design solutions using high-quality materials and innovative techniques to help you achieve an exceptional brand identity in every detail.',
                'image' => 'slider1.png',
                'is_active' => 1,
            ]);

        }

    }
}
