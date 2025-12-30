<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->bound('blade.compiler')) {
            $compiler = $this->app->make('blade.compiler');
            // lanjutkan logic aman di sini
            // Custom directive untuk cek admin
            Blade::if('admin', function () {
                return Auth::check() && Auth::user()->aktor_id == '1';
            });
        }
    }
}
