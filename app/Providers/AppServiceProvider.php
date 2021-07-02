<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->load_helper();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         // Force generating https in url helper
         if(config('app.env') == 'production'){
            URL::forceScheme('https');
        }

        // Add blade custom conditions
        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });
        Blade::if('value', function ($name) {
            if (empty($name)) {
                return false;
            }
            if (isset($name)) {
                return true;
            }
            return false;
        });

        // Override server timezome to match local time (Indonesia)
        setlocale(LC_TIME, 'id_ID.utf8');

        // Config Carbon local time
        Carbon::setLocale(config('app.locale'));
    }

        /**
     * Register custom global helper.
     *
     * @return void
     */
    public function load_helper()
    {
        foreach ( glob(__DIR__.'/../Helpers/*.php') as $filename ) {
            require_once $filename;
        }
    }
}
