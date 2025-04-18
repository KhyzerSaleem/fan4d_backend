<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'site_name_ar' => 'فن',
            'site_name_en' => 'FANN',
            'phone' => '96612345678',
            'email' => 'info@lowcalories.com',
            'registration_number' => '987654',
            'website' => "https://google.com",
            'address_ar' => 'الرياض - السعودية',
            'address_en' => 'Riyadh - Saudi Arabia',
//            'android_version' => 1,
//            'ios_version' => 1,

            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://www.x.com/',
            'instagram' => 'https://www.instagram.com/',
            'accessKey' => 'accessKey9A3q9p6V0eKVizqYt9Su9KAMfORbccWrvoJVUCGPKqHBvEgvtJq',
            'tax_percent' => '14',
//            'shipping_fee' => 10,
//            'tax_percent' => 15,
//            'order_count_per_day' => 10,
            'reward_points' => 1000,
            'reward_money' => 100,
            'order_money' => 100,
            'order_points' => 100,
        ];


        foreach ($data as $key => $value) {
            Setting::updateOrCreate([
                'key' => $key
            ],[
                'value' => $value,
            ]);
        }

        Setting::updateOrCreate([
            'key' => 'fav_icon'
        ],['value' => 'image', 'image' => 'fav_icon.png']);
        Setting::updateOrCreate([
            'key' => 'logo'
        ],['value' => 'image', 'image' => 'web_logo.png']);
        Setting::updateOrCreate(array(
            'key' => 'logo_login'
        ),[ 'value' => 'image', 'image' => 'login_page_logo.png']);
    }
}
