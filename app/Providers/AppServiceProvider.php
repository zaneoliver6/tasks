<?php

namespace App\Providers;

use App\Observers\TaskObserver;
use Illuminate\Support\ServiceProvider;
use App\Task;

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
        // Register Observers
        Task::observe(TaskObserver::class);
    }
}
