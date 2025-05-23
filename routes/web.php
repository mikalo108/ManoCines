<?php

use App\Http\Controllers\ChairController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\OrderTicketController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductCinemaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TemporalReserveController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

Route::get('/locale/{locale}', function ($locale, Request $request) {
    $availableLocales = ['en', 'es'];

    if (in_array($locale, $availableLocales)) {
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
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'locale' => app()->getLocale(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chairs
    Route::get('chairs/{chair}', [ChairController::class, 'show'])->name('chairs.show');
    Route::put('chairs/{chair}', [ChairController::class, 'update'])->name('chairs.update');
    Route::delete('chairs/{chair}', [ChairController::class, 'destroy'])->name('chairs.destroy');

    // Cinemas
    Route::get('cinemas/{cinema}', [CinemaController::class, 'show'])->name('cinemas.show');
    Route::put('cinemas/{cinema}', [CinemaController::class, 'update'])->name('cinemas.update');
    Route::delete('cinemas/{cinema}', [CinemaController::class, 'destroy'])->name('cinemas.destroy');

    // Cities
    Route::get('cities/{city}', [CityController::class, 'show'])->name('cities.show');
    Route::put('cities/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');

    // Films
    Route::get('films/{film}', [FilmController::class, 'show'])->name('films.show');
    Route::put('films/{film}', [FilmController::class, 'update'])->name('films.update');
    Route::delete('films/{film}', [FilmController::class, 'destroy'])->name('films.destroy');

    // Orders
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Order Products
    Route::get('order-products/{order_product}', [OrderProductController::class, 'show'])->name('order-products.show');
    Route::put('order-products/{order_product}', [OrderProductController::class, 'update'])->name('order-products.update');
    Route::delete('order-products/{order_product}', [OrderProductController::class, 'destroy'])->name('order-products.destroy');

    // Order Tickets
    Route::get('order-tickets/{order_ticket}', [OrderTicketController::class, 'show'])->name('order-tickets.show');
    Route::put('order-tickets/{order_ticket}', [OrderTicketController::class, 'update'])->name('order-tickets.update');
    Route::delete('order-tickets/{order_ticket}', [OrderTicketController::class, 'destroy'])->name('order-tickets.destroy');

    // Product Categories
    Route::get('product-categories/{product_category}', [ProductCategoryController::class, 'show'])->name('product-categories.show');
    Route::put('product-categories/{product_category}', [ProductCategoryController::class, 'update'])->name('product-categories.update');
    Route::delete('product-categories/{product_category}', [ProductCategoryController::class, 'destroy'])->name('product-categories.destroy');

    // Product Cinemas
    Route::get('product-cinemas/{product_cinema}', [ProductCinemaController::class, 'show'])->name('product-cinemas.show');
    Route::put('product-cinemas/{product_cinema}', [ProductCinemaController::class, 'update'])->name('product-cinemas.update');
    Route::delete('product-cinemas/{product_cinema}', [ProductCinemaController::class, 'destroy'])->name('product-cinemas.destroy');

    // Products
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Rooms
    Route::get('rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::put('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Temporal Reserves
    Route::get('temporal-reserves/{temporal_reserve}', [TemporalReserveController::class, 'show'])->name('temporal-reserves.show');
    Route::put('temporal-reserves/{temporal_reserve}', [TemporalReserveController::class, 'update'])->name('temporal-reserves.update');
    Route::delete('temporal-reserves/{temporal_reserve}', [TemporalReserveController::class, 'destroy'])->name('temporal-reserves.destroy');

    // Times
    Route::get('times/{time}', [TimeController::class, 'show'])->name('times.show');
    Route::put('times/{time}', [TimeController::class, 'update'])->name('times.update');
    Route::delete('times/{time}', [TimeController::class, 'destroy'])->name('times.destroy');

    // Users
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
