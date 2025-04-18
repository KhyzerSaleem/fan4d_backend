<?php

namespace Database\Seeders;

use App\Models\MedicalInstruction;
use App\Models\Splash;
use Illuminate\Database\Seeder;

class SplashesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Splash::where('id', 1)->first();
        if (!$exists_data) {
            Splash::updateOrCreate([
                'id' => 1,
                'title_ar' => 'اكتشف النظام الغذائي المناسب',
                'title_en' => 'Explore the Suitable Dietary Plan',
                'desc_ar' => 'اكتشف الخطة الغذائية المناسبة لصحتك واحتياجاتك الغذائية من خلال الخيارات الصحية واللذيذة المتوفرة',
                'desc_en' => 'Explore the appropriate dietary plan for your health and nutritional needs through healthy and delicious options available',
                'image' => 'splash1.png',
                'is_active' => 1,
            ]);

            Splash::updateOrCreate([
                'id' => 2,
                'title_ar' => 'وجبات متنوعة متاحة',
                'title_en' => 'Available Diverse Meals',
                'desc_ar' => 'استمتع بتجربة متنوعة من الوجبات اللذيذة واكتشف الخيارات المتاحة لتناسب تفضيلاتك الغذائية المتنوعة',
                'desc_en' => 'Enjoy a diverse experience of delicious meals and discover the available options to meet your varied dietary preferences',
                'image' => 'splash2.png',
                'is_active' => 1,
            ]);

            Splash::updateOrCreate([
                'id' => 3,
                'title_ar' => 'نظام النقاط والمكافآت',
                'title_en' => 'Points and Rewards System',
                'desc_ar' => 'اكسب نقاطًا مع الطلبات، واستردها مقابل مكافآت، واستمتع بخصومات حصرية لتجربة طعام مجزية',
                'desc_en' => 'Earn points with orders, redeem for rewards, and enjoy exclusive discounts for a rewarding dining experience',
                'image' => 'splash3.png',
                'is_active' => 1,
            ]);

            Splash::updateOrCreate([
                'id' => 4,
                'title_ar' => 'نظام التنبيهات والتذكيرات',
                'title_en' => 'Alerts and Reminders System',
                'desc_ar' => 'احصل على تنبيهات مهمة بشأن الوجبات التي تهمك وتذكيرات صحية للحفاظ على العافية وتحقيق الأهداف الغذائية',
                'desc_en' => 'Earn points with orders, redeem for rewards, and enjoy exclusive discounts for a rewarding dining experience',
                'image' => 'splash4.png',
                'is_active' => 1,
            ]);


        }

    }
}
