<?php

namespace App\Providers;

use App\Console\Commands\UpdateTemporalReserves;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Film;
use App\Models\Room;
use App\Models\Time;
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
        //$schedule->command(UpdateTemporalReserves::handle());
        
        $films = Film::orderBy('id', 'desc')->get();
        $rooms = Room::orderBy('id', 'desc')->get();
        $times = Time::orderBy('id', 'desc')->get();
        
        app()->setLocale(session('locale', app()->getLocale()));  
        // Share the same data with Inertia views
        Inertia::share([
            'allFilms' => $films,
            'allRooms' => $rooms,
            'allTimes' => $times,
            'appName' => config('app.name'),
            'auth' => fn () => ['user' => Auth::user()],
            'lang' => fn () => Lang::get('general'),
            'locale' => fn () => session('locale', config('app.locale')),
        ]);
        
    }
}
