<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('datetime', function ($attribute, $value, $parameters, $validator) {
            // Define the regex pattern for datetime format (YYYY-MM-DD HH:MM:SS)
            $pattern = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';

            // Validate the value against the regex pattern
            return preg_match($pattern, $value) === 1;
        });
    }
}