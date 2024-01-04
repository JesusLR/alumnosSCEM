<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Portal_configuracion;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        Schema::defaultStringLength(191);
        \Debugbar::disable();
        Paginator::useBootstrap();
        $configs = Portal_configuracion::Where('pcPortal', 'A')->get();

        foreach ($configs as $config) {
            $portConfActivo = $config->pcEstado == 'A' ? true: false;
            View::share($config->pcClave, $portConfActivo);
        }
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
