<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Attribute::where('id', 1)->first();
        if (!$exists_data) {
            Attribute::create([
                'id' => 1,
                'title_ar' => 'لون الوجه الاول',
                'title_en' => 'First face color',
            ]);

            Attribute::create([
                'id' => 2,
                'title_ar' => 'المقاس',
                'title_en' => 'Size',
            ]);
            Attribute::create([
                'id' => 3,
                'title_ar' => 'الوجه',
                'title_en' => 'Face',
            ]);
            Attribute::create([
                'id' => 4,
                'title_ar' => 'نوع الماده',
                'title_en' => 'Material type',
            ]);
            Attribute::create([
                'id' => 5,
                'title_ar' => 'السولوفان',
                'title_en' => 'Cellophane',
            ]);

            Attribute::create([
                'id' => 6,
                'title_ar' => 'سبوت يوفى',
                'title_en' => 'spot youvy',
            ]);
        }
    }
}
