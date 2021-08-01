<?php

namespace App\Providers;

use App\Models\Plati;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('layouts.app', static function ($view) use ($plati, $request) {
            $view->with('q', $request->get('q'));
            $view->with('statistics', $plati->getStatisticsFromCache());
            $view->with('sidebar', $plati->getSidebarFromCache());
        });
    }
}
