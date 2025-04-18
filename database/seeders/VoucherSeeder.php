<?php

namespace Database\Seeders;

use App\Models\MedicalInstruction;
use App\Models\Splash;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Voucher::where('id', 1)->first();
        if (!$exists_data) {
            Voucher::updateOrCreate([
                'id' => 1,
                'title_ar' => 'خصم 10% على الطلبات التي تزيد عن 50 ريال سعودي!',
                'title_en' => '10% Off on Orders Over 50SAR!',
                'desc_ar' => 'انسخ الكود واحصل على خصم 10% عند الشراء بقيمة 200 ريال أو أكثر.',
                'desc_en' => 'Copy the code and get 10% off when you spend 200 SAR or more.',
                'image' => 'voucher1.png',
                'code' => 'calorie10',
                'start_date' => '2024-10-01',
                'expire_date' => '2024-10-30',
                'user_use_count' => 10,
                'use_count' => 50,
                'percent' => 10,
                'min_order_price' => 50,
            ]);

            Voucher::updateOrCreate([
                'id' => 2,
                'title_ar' => 'خصم 30% على الطلبات التي تزيد عن 375 ريال سعودي!',
                'title_en' => '30% Off on Orders Over 375 SAR!',
                'desc_ar' => 'انسخ الكود واحصل على خصم 10% عند الشراء بقيمة 200 ريال أو أكثر.',
                'desc_en' => 'Copy the code and get 10% off when you spend 200 SAR or more.',
                'image' => 'voucher2.png',
                'code' => 'calorie30',
                'start_date' => '2024-10-01',
                'expire_date' => '2024-11-18',
                'user_use_count' => 10,
                'use_count' => 50,
                'percent' => 30,
                'min_order_price' => 375,
            ]);


        }

    }
}
