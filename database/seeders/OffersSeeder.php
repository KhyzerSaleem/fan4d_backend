<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Offer::where('id', 1)->first();
        if (!$exists_data) {
            Offer::updateOrCreate([
                'id' => 1,
                'title_ar' => 'خدمات طباعة وتصميم وتغليف بجودة استثنائية لكل منتج',
                'title_en' => 'Exceptional quality printing, design and packaging services for every product.',
                'desc_ar' => 'في فن، نقدم حلول طباعة وتصميم مخصصة باستخدام مواد عالية الجودة وتقنيات مبتكرة لنساعدك في تحقيق هوية تجارية استثنائية بكل تفاصيلها.',
                'desc_en' => 'At Fan, we provide customized printing and design solutions using high-quality materials and innovative techniques to help you achieve an exceptional brand identity in every detail.',
                'image' => 'Offer1.png',
                'is_active' => 1,
            ]);
            Offer::updateOrCreate([
                'id' => 2,
                'title_ar' => 'خدمات طباعة وتصميم وتغليف بجودة استثنائية لكل منتج',
                'title_en' => 'Exceptional quality printing, design and packaging services for every product.',
                'desc_ar' => 'في فن، نقدم حلول طباعة وتصميم مخصصة باستخدام مواد عالية الجودة وتقنيات مبتكرة لنساعدك في تحقيق هوية تجارية استثنائية بكل تفاصيلها.',
                'desc_en' => 'At Fan, we provide customized printing and design solutions using high-quality materials and innovative techniques to help you achieve an exceptional brand identity in every detail.',
                'image' => 'Offer1.png',
                'is_active' => 1,
            ]);
            Offer::updateOrCreate([
                'id' => 3,
                'title_ar' => 'خدمات طباعة وتصميم وتغليف بجودة استثنائية لكل منتج',
                'title_en' => 'Exceptional quality printing, design and packaging services for every product.',
                'desc_ar' => 'في فن، نقدم حلول طباعة وتصميم مخصصة باستخدام مواد عالية الجودة وتقنيات مبتكرة لنساعدك في تحقيق هوية تجارية استثنائية بكل تفاصيلها.',
                'desc_en' => 'At Fan, we provide customized printing and design solutions using high-quality materials and innovative techniques to help you achieve an exceptional brand identity in every detail.',
                'image' => 'Offer1.png',
                'is_active' => 1,
            ]);

        }

    }
}
