<?php

namespace App\Providers;

use App\Category;
use App\Code;
use App\Dataset;
use App\Observers\CodeObserver;
use App\Observers\DatasetObserver;
use App\Observers\ReplyObserver;
use App\Observers\ThreadObserver;
use App\Reply;
use App\Thread;
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

        \View::composer(['threads.create', 'threads.edit'], function ($view) {
            $view->with('categoryList', Category::orderBy('name')->pluck('id', 'name'));
        });

        \View::composer(['threads._sidebar'], function ($view) {
            $view->with('categories', Category::orderBy('name')->get());
        });

        Dataset::observe(DatasetObserver::class);
        Code::observe(CodeObserver::class);
        Thread::observe(ThreadObserver::class);
        Reply::observe(ReplyObserver::class);
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
