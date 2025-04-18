<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Package;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Branch::where('id', 1)->first();
        if (!$exists_data) {
            Branch::updateOrCreate([
                'id' => 1,
                'title_ar' => 'ملاذ الذواقة',
                'title_en' => 'Gastronome Haven',
                'desc_ar' => 'استمتع بالتميز في فنون الطهي في Gastronome\'s Haven، حيث يمثل كل طبق تحفة فنية تم إعدادها بشغف. تعد أجوائنا الأنيقة وقائمة الطعام المتنوعة بمغامرة طعام لا تُنسى، حيث تمزج النكهات من جميع أنحاء العالم. انغمس في أجواء راقية ترفع تجربة تناول الطعام الخاصة بك إلى آفاق جديدة.',
                'desc_en' => 'Experience culinary excellence at Gastronome\'s Haven, where each dish is a masterpiece crafted with passion. Our elegant ambiance and diverse menu promise a memorable dining adventure, blending flavors from around the world. Immerse yourself in a sophisticated atmosphere that elevates your dining experience to new heights.',
                'image' => 'branch1.png',
                'lat' => '12554545',
                'lng' => '66356065',
                'address_ar' => 'شارع مدينة الرياض',
                'address_en' => 'Riyadh City Boulevard',
                'is_active' => 1,
            ]);

            Branch::updateOrCreate([
                'id' => 2,
                'title_ar' => 'صالة سوشي زين جاردن',
                'title_en' => 'Zen Garden Sushi Lounge',
                'desc_ar' => 'استمتع بالتميز في فنون الطهي في Gastronome\'s Haven، حيث يمثل كل طبق تحفة فنية تم إعدادها بشغف. تعد أجوائنا الأنيقة وقائمة الطعام المتنوعة بمغامرة طعام لا تُنسى، حيث تمزج النكهات من جميع أنحاء العالم. انغمس في أجواء راقية ترفع تجربة تناول الطعام الخاصة بك إلى آفاق جديدة.',
                'desc_en' => 'Experience culinary excellence at Gastronome\'s Haven, where each dish is a masterpiece crafted with passion. Our elegant ambiance and diverse menu promise a memorable dining adventure, blending flavors from around the world. Immerse yourself in a sophisticated atmosphere that elevates your dining experience to new heights.',
                'image' => 'branch2.png',
                'lat' => '12554545',
                'lng' => '66356065',
                'address_ar' => 'شارع مدينة الرياض',
                'address_en' => 'Riyadh City Boulevard',
                'is_active' => 1,
            ]);

            Branch::updateOrCreate([
                'id' => 3,
                'title_ar' => 'مقهى صن سيت سيرينيتي',
                'title_en' => 'Sunset Serenity Cafe',
                'desc_ar' => 'استمتع بالتميز في فنون الطهي في Gastronome\'s Haven، حيث يمثل كل طبق تحفة فنية تم إعدادها بشغف. تعد أجوائنا الأنيقة وقائمة الطعام المتنوعة بمغامرة طعام لا تُنسى، حيث تمزج النكهات من جميع أنحاء العالم. انغمس في أجواء راقية ترفع تجربة تناول الطعام الخاصة بك إلى آفاق جديدة.',
                'desc_en' => 'Experience culinary excellence at Gastronome\'s Haven, where each dish is a masterpiece crafted with passion. Our elegant ambiance and diverse menu promise a memorable dining adventure, blending flavors from around the world. Immerse yourself in a sophisticated atmosphere that elevates your dining experience to new heights.',
                'image' => 'branch3.png',
                'lat' => '12554545',
                'lng' => '66356065',
                'address_ar' => 'شارع مدينة الرياض',
                'address_en' => 'Riyadh City Boulevard',
                'is_active' => 1,
            ]);

        }

    }
}
