<?php

namespace App\Providers;

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
    public function boot()
    {
        $link = public_path('storage');
        if (!File::exists($link)) {
            $this->app->make('files')->link(storage_path('app/public'), $link);
        }
    }
}
