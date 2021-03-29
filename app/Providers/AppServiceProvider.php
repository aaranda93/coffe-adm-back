<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Nomadnt\LumenPassport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }
}
