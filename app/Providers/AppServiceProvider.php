<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Newsletter;
use Laravel\Nova\Nova;
use App\Observers\NewslettersObserver;

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
        //
    }
}
