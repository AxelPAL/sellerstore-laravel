<?php

namespace App\Providers;

use App\Models\Plati;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @param Plati $plati
     * @param Request $request
     * @return void
     */
    public function boot(Plati $plati, Request $request): void
    {
        if ( env('APP_ENV') === 'production' ) {
            URL::forceRootUrl(env('APP_URL'));
            URL::forceScheme('https');
        }
        view()->composer('layouts.app', static function ($view) use ($plati, $request) {
            $view->with('q', $request->get('q'));
            $view->with('statistics', $plati->getStatisticsFromCache());
            $view->with('sidebar', $plati->getSidebarFromCache());
        });
    }
}
