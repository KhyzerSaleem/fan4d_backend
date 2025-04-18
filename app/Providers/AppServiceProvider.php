<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\User;
use App\Observers\NotificationObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        view()->share('locales', config('translatable.locales'));

        date_default_timezone_set('Asia/Riyadh');
        $languages = ['ar', 'en'];
        $lang = request()->header('lang');

        if ($lang) {
            if (in_array($lang, $languages)) {
                App::setLocale($lang);
            } else {
                App::setLocale('ar');
            }
        }

        if (!session()->has('lang')) {
            session()->put('lang', 'ar');
        }

        if (Schema::hasTable('users')) {
            Artisan::call('schedule:run');
            User::observe(UserObserver::class);

            Notification::observe(NotificationObserver::class);
        }


    }
}
