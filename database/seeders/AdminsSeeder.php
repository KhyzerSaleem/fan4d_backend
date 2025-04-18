<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Sponser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists_role = Admin::whereId(1)->first();
        if(!$exists_role) {
            $superAdmin = Admin::create([
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'phone' => '0123456',
                'password' => '123456',
                'type' => 'admin',
            ]);

            $superAdmin->addRole(Role::where('name', 'super_admin')->first());
        }
    }
}
