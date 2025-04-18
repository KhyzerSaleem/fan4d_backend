<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_country = City::whereId(1)->first();
        if (!$exists_country) {
            $country = City::create([
                'id' => 1,
                'title_ar' => 'الرياض',
                'title_en' => 'Riyadh',
                'is_active' => 1,
            ]);
            $cities = [
                [
                    'id' => 1,
                    'city_id' => $country->id,
                    'title_ar' => 'محافظة الدرعية',
                    'title_en' => 'Diriyah Governorate',
                    'is_active' => 1,
                ],
                [
                    'id' => 2,
                    'city_id' => $country->id,
                    'title_ar' => 'محافظة المجمعة',
                    'title_en' => 'Majmaah Governorate',
                    'is_active' => 1,
                ],
            ];
            foreach ($cities as $city) {
                Area::create($city);
            }

            $country = City::create([
                'id' => 2,
                'title_ar' => 'جدة',
                'title_en' => 'gadda',
                'is_active' => 1,
            ]);
            $cities = [
                [
                    'id' => 3,
                    'city_id' => $country->id,
                    'title_ar' => 'حى الحمراء',
                    'title_en' => 'Al Hamra district',
                    'is_active' => 1,
                ],
                [
                    'id' => 4,
                    'city_id' => $country->id,
                    'title_ar' => 'حى الخالدية',
                    'title_en' => 'Khalidiya District',
                    'is_active' => 1,
                ],
            ];
            foreach ($cities as $city) {
                Area::create($city);
            }
        }


    }
}
