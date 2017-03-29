<?php

namespace App\Providers;

use App\Code;
use App\Dataset;
use App\Observers\CodeObserver;
use App\Observers\DatasetObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);
        Dataset::observe(DatasetObserver::class);
        Code::observe(CodeObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
