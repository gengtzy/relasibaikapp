<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (isset($_ENV['VERCEL']) || env('VERCEL')) {
            $path = '/tmp/storage';
            
            // Beritahu Laravel pakai path ini
            $this->app->useStoragePath($path);

            // Buat struktur folder wajib secara manual
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
                mkdir($path . '/framework/cache', 0777, true);
                mkdir($path . '/framework/views', 0777, true);
                mkdir($path . '/framework/sessions', 0777, true);
                // Folder khusus Livewire Temp Upload (PENTING!)
                mkdir($path . '/app/livewire-tmp', 0777, true); 
            }
            
            // Config khusus untuk cache view agar tidak error
            config(['view.compiled' => $path . '/framework/views']);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
