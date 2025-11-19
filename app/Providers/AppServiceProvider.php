<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

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
        // --- Storage symlink ---
        $link = public_path('storage');
        if (!File::exists($link)) {
            try {
                File::link(storage_path('app/public'), $link);
            } catch (\Exception $e) {
                Log::warning('Storage link non creato: ' . $e->getMessage());
            }
        }

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }

}
