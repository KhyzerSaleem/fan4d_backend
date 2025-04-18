<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Page::count() < 3) {

            Page::truncate();

            Page::create([
                'id' => 1,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
                'type' => 'about',
                'image' => 'terms.png'
            ]);
            Page::create([
                'id' => 2,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
                'type' => 'terms',
                'image' => 'fann_logo.png'
            ]);

            Page::create([
                'id' => 3,
                'desc_ar' => 'لوريم إيبسوم هو نص عباري وهمي يُستخدم في صناعات المطابع والتنضيد. كتب هذا النص بواسطة الطبيب والفيلسوف المتخصص في علم النفس، "لوريم إيبسوم" عام ١٩٥٠. حيث يمثل "لوريم إيبسوم" نصًا وهميًا في الصناعات',
                'desc_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                 Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                 ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                  voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                  sint occaecat cupidatat non proident,
                 sunt in culpa qui officia deserunt mollit anim id est laborum',
                'type' => 'privacy',
                'image' => 'fann_logo.png'
            ]);
        }
    }
}
