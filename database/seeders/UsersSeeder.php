<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_role = User::whereId(1)->first();
        if(!$exists_role) {
            User::create(
                [
                    'id' => 1,
                    'name' => 'Mohamed nasser',
                    'email' => 'client@gmail.com',
                    'country_code' => '966',
                    'phone' => '50000800',
                    'city_id' => 1,
                    'email_verified_at' => now(),
                    'platform' => 'android',
                    'date_of_birth' => '1995-08-22',
                    'password' => Hash::make('12345678'),
                    'remember_token' => Str::random(10),
                ]
            );
            User::factory()->count(10)->create();
        }
    }
}
