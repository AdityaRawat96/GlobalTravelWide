<?php

namespace App\Providers;

use App\Repository\ImpInterface;
use App\Repository\ImpRepo;
use Illuminate\Support\ServiceProvider;


class RepositeryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ImpInterface::class,
            ImpRepo::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
