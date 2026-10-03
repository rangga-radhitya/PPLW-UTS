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
    public function boot(): void
   {
       $host = request()->getHost();

       if (request()->header('X-Forwarded-Proto') === 'https'
           || str_contains($host, 'trycloudflare.com')
           || str_contains($host, 'ngrok')) {
           \Illuminate\Support\Facades\URL::forceScheme('https');
       }
   }
}
