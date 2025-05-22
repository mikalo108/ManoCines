<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Laravel\Pail\ValueObjects\Origin\Console;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


Route::get('/locale/{locale}', function ($locale, Request $request) {
    $availableLocales = ['en', 'es'];

    if (in_array($locale, $availableLocales)) {
        App::setLocale($locale);
        Session::put('locale', $locale);
        cookie()->queue(cookie()->forever('locale', $locale));
        Lang::setLocale($locale);
        return redirect()->back()->with('success', 'Locale switched to: ' . $locale);
    } else {
        return redirect()->back();
    }
})->name('locale.switch');

Route::get('/', function () {
    App::setLocale(session('locale', config('app.locale')));
    return Inertia::render('Welcome', [
        'auth' => [
            'user' => Auth::user(),
        ],
        'locale' => App::getLocale(),
        'locale_session' => session('locale'),
        'copyright' => Lang::get('general.copyright'),
        'bestsellers' => Lang::get('general.bestsellers'),
        'films' => Lang::get('general.films'),
        'cinemas' => Lang::get('general.cinemas'),
        'register' => Lang::get('general.register'),
        'login' => Lang::get('general.login'),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name(name: 'home');



Route::get('/dashboard', function () {
    App::setLocale(session('locale', config('app.locale')));
    return Inertia::render('Dashboard', [
        'locale' => App::getLocale(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';

