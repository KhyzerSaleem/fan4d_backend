<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_data = Address::where('id', 1)->where('user_id', 1)->first();
        if (!$exists_data) {
            Address::create([
                'id' => 1,
                'user_id' => 1,
                'address' => 'test address',
                'street' => 'street name',
                'house_number' => '15',
                'lat' => 3454551.1,
                'lng' => 3045545.2,
                'title' => 30.2,
                'city_id' => 1,
                'area_id' => 1,
                'is_default' => 1,
            ]);

        }
    }
}
