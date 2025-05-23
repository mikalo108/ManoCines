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


Route::get('/locale/{locale}', function ($locale, Request $request) {
    $availableLocales = ['en', 'es'];

    if (in_array($locale, $availableLocales)) {
        Log::info('Locale changed to: ' . $locale);
        app()->setLocale($locale);
        $request->session()->put('locale', $locale);
        cookie()->queue(cookie()->forever('locale', $locale));
    } else {
        Log::warning('Attempted to set an unavailable locale: ' . $locale);
    }

    return response()->noContent();
})->name('locale.switch');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'auth' => [
            'user' => Auth::user(),
        ],
        'locale' => session('locale', app()->getLocale()),
        'locale_session' => session('locale'),
        'copyright' => Lang::get('general.copyright'),
        'bestsellers' => Lang::get('general.bestsellers'),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name(name: 'home');



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'locale' => app()->getLocale(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';

