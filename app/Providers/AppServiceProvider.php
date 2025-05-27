<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Film;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;

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
        
        $films = Film::withCount('orders')->orderBy('orders_count', 'desc')->get();
        View::share('allFilms', $films);
        
        // Share the same data with Inertia views
        Inertia::share([
            'allFilms' => $films,
            'appName' => config('app.name'),
            'auth' => fn () => ['user' => Auth::user()],
            'lang' => fn () => Lang::get('general'),
            'locale' => fn () => session('locale', config('app.locale')),
        ]);
        
    }
}
