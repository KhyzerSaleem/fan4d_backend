<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(AdminsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AddressesSeeder::class);
        $this->call(SplashesSeeder::class);
        $this->call(BranchesSeeder::class);
        $this->call(SlidersSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(StepsSeeder::class);
        $this->call(OffersSeeder::class);
        $this->call(ReviewsSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(VoucherSeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(AttributesSeeder::class);
    }
}
