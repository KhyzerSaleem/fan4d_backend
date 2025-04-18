<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Gift;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\Room;
use App\Models\Sponser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create Roles
       $exists_role = Role::whereId(1)->first();
       if(!$exists_role) {
           $adminRole = Role::create([
               'id' => 1,
               'name' => 'super_admin',
               'display_name_ar' => 'الادمن الرئيسي',
               'display_name_en' => 'Super Admin',
           ]);
           $adminRole->givePermissions(Permission::all());

       }
        // assign permissions to role
    }
}
