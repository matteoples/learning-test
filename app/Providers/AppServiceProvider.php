<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

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
        // Crea automaticamente il symlink storage -> public/storage se non esiste
        $link = public_path('storage');
        if (!File::exists($link)) {
            try {
                File::link(storage_path('app/public'), $link);
            } catch (\Exception $e) {
                // Se fallisce (per esempio su Render gratuito), ignora
                \Log::warning('Storage link non creato: ' . $e->getMessage());
            }
        }
    }
}
