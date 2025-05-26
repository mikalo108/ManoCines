<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Film;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

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
     * @param Schedule $schedule
     * @return void
     */
    public function boot(Schedule $schedule)
    {
        $schedule->command('temporalreserves:update')->everyMinute();

        // Load all films ordered by number of associated orders descending and share with all views globally
        $films = Film::withCount('orders')->orderBy('orders_count', 'desc')->get();
        View::share('allFilms', $films);
        
        // Share the same data with Inertia views
        Inertia::share([
            'lang' => function () {
                return Lang::get('general');
            },
            'allFilms' => $films,
            'appName' => config('app.name'),
            'locale' => session('locale', app()->getLocale()),

        ]);
    }
}
