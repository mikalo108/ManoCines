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
    Route::get('chairs', [ChairController::class, 'index'])->name('chairs.index');
    Route::get('chairs/create', [ChairController::class, 'create'])->name('chairs.create');
    Route::post('chairs', [ChairController::class, 'store'])->name('chairs.store');
    Route::get('chairs/edit/{chair}', [ChairController::class, 'edit'])->name('chairs.edit');
    Route::put('chairs/{chair}', [ChairController::class, 'update'])->name('chairs.update');
    Route::delete('chairs/{chair}', [ChairController::class, 'destroy'])->name('chairs.destroy');
    Route::get('chairs/{chair}', [ChairController::class, 'show'])->name('chairs.show');

    // Cinemas
    Route::get('cinemas', [CinemaController::class, 'index'])->name('cinemas.index');
    Route::get('cinemas/create', [CinemaController::class, 'create'])->name('cinemas.create');
    Route::post('cinemas', [CinemaController::class, 'store'])->name('cinemas.store');
    Route::get('cinemas/edit/{cinema}', [CinemaController::class, 'edit'])->name('cinemas.edit');
    Route::put('cinemas/{cinema}', [CinemaController::class, 'update'])->name('cinemas.update');
    Route::delete('cinemas/{cinema}', [CinemaController::class, 'destroy'])->name('cinemas.destroy');
    Route::get('cinemas/{cinema}', [CinemaController::class, 'show'])->name('cinemas.show');

    // Cities
    Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('cities/create', [CityController::class, 'create'])->name('cities.create');
    Route::post('cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('cities/edit/{city}', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('cities/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('cities/{city}', [CityController::class, 'destroy'])->name('cities.destroy');
    Route::get('cities/{city}', [CityController::class, 'show'])->name('cities.show');

    // Films
    Route::get('films', [FilmController::class, 'index'])->name('films.index');
    Route::get('films/create', [FilmController::class, 'create'])->name('films.create');
    Route::post('films', [FilmController::class, 'store'])->name('films.store');
    Route::get('films/edit/{film}', [FilmController::class, 'edit'])->name('films.edit');
    Route::put('films/{film}', [FilmController::class, 'update'])->name('films.update');
    Route::delete('films/{film}', [FilmController::class, 'destroy'])->name('films.destroy');
    Route::get('films/{film}', [FilmController::class, 'show'])->name('films.show');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/edit/{order}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Order Products
    Route::get('order-products', [OrderProductController::class, 'index'])->name('order-products.index');
    Route::get('order-products/create', [OrderProductController::class, 'create'])->name('order-products.create');
    Route::post('order-products', [OrderProductController::class, 'store'])->name('order-products.store');
    Route::get('order-products/edit/{order_product}', [OrderProductController::class, 'edit'])->name('order-products.edit');
    Route::put('order-products/{order_product}', [OrderProductController::class, 'update'])->name('order-products.update');
    Route::delete('order-products/{order_product}', [OrderProductController::class, 'destroy'])->name('order-products.destroy');
    Route::get('order-products/{order_product}', [OrderProductController::class, 'show'])->name('order-products.show');

    // Order Tickets
    Route::get('order-tickets', [OrderTicketController::class, 'index'])->name('order-tickets.index');
    Route::get('order-tickets/create', [OrderTicketController::class, 'create'])->name('order-tickets.create');
    Route::post('order-tickets', [OrderTicketController::class, 'store'])->name('order-tickets.store');
    Route::get('order-tickets/edit/{order_ticket}', [OrderTicketController::class, 'edit'])->name('order-tickets.edit');
    Route::put('order-tickets/{order_ticket}', [OrderTicketController::class, 'update'])->name('order-tickets.update');
    Route::delete('order-tickets/{order_ticket}', [OrderTicketController::class, 'destroy'])->name('order-tickets.destroy');
    Route::get('order-tickets/{order_ticket}', [OrderTicketController::class, 'show'])->name('order-tickets.show');

    // Product Categories
    Route::get('product-categories', [ProductCategoryController::class, 'index'])->name('product-categories.index');
    Route::get('product-categories/create', [ProductCategoryController::class, 'create'])->name('product-categories.create');
    Route::post('product-categories', [ProductCategoryController::class, 'store'])->name('product-categories.store');
    Route::get('product-categories/edit/{product_category}', [ProductCategoryController::class, 'edit'])->name('product-categories.edit');
    Route::put('product-categories/{product_category}', [ProductCategoryController::class, 'update'])->name('product-categories.update');
    Route::delete('product-categories/{product_category}', [ProductCategoryController::class, 'destroy'])->name('product-categories.destroy');
    Route::get('product-categories/{product_category}', [ProductCategoryController::class, 'show'])->name('product-categories.show');

    // Product Cinemas
    Route::get('product-cinemas', [ProductCinemaController::class, 'index'])->name('product-cinemas.index');
    Route::get('product-cinemas/create', [ProductCinemaController::class, 'create'])->name('product-cinemas.create');
    Route::post('product-cinemas', [ProductCinemaController::class, 'store'])->name('product-cinemas.store');
    Route::get('product-cinemas/edit/{product_cinema}', [ProductCinemaController::class, 'edit'])->name('product-cinemas.edit');
    Route::put('product-cinemas/{product_cinema}', [ProductCinemaController::class, 'update'])->name('product-cinemas.update');
    Route::delete('product-cinemas/{product_cinema}', [ProductCinemaController::class, 'destroy'])->name('product-cinemas.destroy');
    Route::get('product-cinemas/{product_cinema}', [ProductCinemaController::class, 'show'])->name('product-cinemas.show');

    // Products
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Profiles
    Route::get('profiles', [ProfileController::class, 'index'])->name('profiles.index');
    Route::get('profiles/create', [ProfileController::class, 'create'])->name('profiles.create');
    Route::post('profiles', [ProfileController::class, 'store'])->name('profiles.store');
    Route::get('profiles/edit/{profile}', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('profiles/{profile}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('profiles/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');
    Route::get('profiles/{profile}', [ProfileController::class, 'show'])->name('profiles.show');
    
    // Rooms
    Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('rooms/edit/{room}', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

    // Temporal Reserves
    Route::get('temporal-reserves', [TemporalReserveController::class, 'index'])->name('temporal-reserves.index');
    Route::get('temporal-reserves/create', [TemporalReserveController::class, 'create'])->name('temporal-reserves.create');
    Route::post('temporal-reserves', [TemporalReserveController::class, 'store'])->name('temporal-reserves.store');
    Route::get('temporal-reserves/edit/{temporal_reserve}', [TemporalReserveController::class, 'edit'])->name('temporal-reserves.edit');
    Route::put('temporal-reserves/{temporal_reserve}', [TemporalReserveController::class, 'update'])->name('temporal-reserves.update');
    Route::delete('temporal-reserves/{temporal_reserve}', [TemporalReserveController::class, 'destroy'])->name('temporal-reserves.destroy');
    Route::get('temporal-reserves/{temporal_reserve}', [TemporalReserveController::class, 'show'])->name('temporal-reserves.show');

    // Times
    Route::get('times', [TimeController::class, 'index'])->name('times.index');
    Route::get('times/create', [TimeController::class, 'create'])->name('times.create');
    Route::post('times', [TimeController::class, 'store'])->name('times.store');
    Route::get('times/edit/{time}', [TimeController::class, 'edit'])->name('times.edit');
    Route::put('times/{time}', [TimeController::class, 'update'])->name('times.update');
    Route::delete('times/{time}', [TimeController::class, 'destroy'])->name('times.destroy');
    Route::get('times/{time}', [TimeController::class, 'show'])->name('times.show');

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
});

require __DIR__.'/auth.php';
