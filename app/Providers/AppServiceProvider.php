<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::directive('level', function ($value) {
            $result = '';
            switch ($value) {
                case 0:
                    $result = 'Super Admin';
                    break;
                case 1:
                    $result = 'Petugas MA';
                    break;
                case 2:
                    $result = 'Petugas Pengujian';
                    break;

                default:
                    $result = 'Not defined';
                    break;
            }

            return $result;
        });
    }
}
