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
        // Resolve breadcrumbs path at runtime (before package boot). Config cache created on Windows
        // embeds C:\... paths; Docker on Linux would otherwise require a non-existent host path.
        $this->app->booting(function () {
            $path = base_path('routes/breadcrumbs.php');
            config(['breadcrumbs.files' => is_file($path) ? $path : []]);
        });
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
            URL::forceRootUrl((string) config('app.url'));
            URL::forceScheme('https');
        }
        view()->composer('layouts.app', static function ($view) use ($plati, $request) {
            $view->with('q', $request->get('q'));
            $view->with('statistics', $plati->getStatisticsFromCache());
            $view->with('sidebar', $plati->getSidebarFromCache());
        });
    }
}
