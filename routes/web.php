<?php

use App\Http\Controllers\ChairController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CinemaRoomController;
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
use App\Models\City;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/locale/{locale}', function ($locale, Request $request) {
    $availableLocales = ['en', 'es'];

    if (!in_array($locale, $availableLocales)) {
        Log::warning('Attempted to set an unavailable locale: ' . $locale);
        abort(404);
    }

    app()->setLocale($locale);
    $request->session()->put('locale', $locale);
    cookie()->queue(cookie()->forever('locale', $locale));
})->middleware('web')->where('locale', '[a-zA-Z]{2}')->name('locale.switch');

Route::get('/', function () {
    app()->setLocale(session('locale', app()->getLocale()));
    return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'), 
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
})->name('home');

Route::get('/dashboard', function () {
    app()->setLocale(session('locale', app()->getLocale()));
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'), 
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', function () {
    app()->setLocale(session('locale', app()->getLocale()));
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'), 
        'canRegister' => Route::has('register'),
        'canResetPassword' => Route::has('password.request'),
        'status' => session('status', ''),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('guest')->name('login');

Route::get('/register', function () {
    app()->setLocale(session('locale', app()->getLocale()));
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return Inertia::render('Auth/Register', [
        'canLogin' => Route::has('login'), 
        'canRegister' => Route::has('register'),
        'canResetPassword' => Route::has('password.request'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'status' => session('status', ''),
    ]);
})->middleware('guest')->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('home');
    })->name('logout');

    // Chairs
    Route::get('chairs', [ChairController::class, 'index'])->name('chairs.index');
    Route::get('/{cinema}/{film}/{room}/{time}/chairs', [ChairController::class, 'indexForATime'])->name('chairs.time');
    Route::post('/{cinema_id}/{film_id}/{time_id}/{room_id}/chairs/select', [ChairController::class, 'selectChair'])->name('chairs.select');
    Route::get('chairs/create', [ChairController::class, 'create'])->name('chairs.create');
    Route::post('chairs/store', [ChairController::class, 'store'])->name('chairs.store');
    Route::get('chairs/edit/{chair}', [ChairController::class, 'edit'])->name('chairs.edit');
    Route::put('chairs/update/{chair}', [ChairController::class, 'update'])->name('chairs.update');
    Route::get('chairs/delete/{chair}', [ChairController::class, 'destroy'])->name('chairs.destroy');

    // Cinemas
    Route::get('cinemas', [CinemaController::class, 'index'])->name('cinemas.index');
    Route::get('cinemas/create', [CinemaController::class, 'create'])->name('cinemas.create');
    Route::post('cinemas/store', [CinemaController::class, 'store'])->name('cinemas.store');
    Route::get('cinemas/edit/{cinema}', [CinemaController::class, 'edit'])->name('cinemas.edit');
    Route::put('cinemas/update/{cinema}', [CinemaController::class, 'update'])->name('cinemas.update');
    Route::get('cinemas/delete/{cinema}', [CinemaController::class, 'destroy'])->name('cinemas.destroy');
    
    // Cinema Rooms
    Route::get('cinema-rooms', [CinemaRoomController::class, 'index'])->name('cinema-rooms.index');
    Route::get('cinema-rooms/create', [CinemaRoomController::class, 'create'])->name('cinema-rooms.create');
    Route::post('cinema-rooms/store', [CinemaRoomController::class, 'store'])->name('cinema-rooms.store');
    Route::get('cinema-rooms/edit/{cinema_room}', [CinemaRoomController::class, 'edit'])->name('cinema-rooms.edit');
    Route::put('cinema-rooms/update/{cinema_room}', [CinemaRoomController::class, 'update'])->name('cinema-rooms.update');
    Route::get('cinema-rooms/delete/{cinema_room}', [CinemaRoomController::class, 'destroy'])->name('cinema-rooms.destroy');

    // Cities
    Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    Route::get('cities/create', [CityController::class, 'create'])->name('cities.create');
    Route::post('cities/store', [CityController::class, 'store'])->name('cities.store');
    Route::get('cities/edit/{city}', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('cities/update/{city}', [CityController::class, 'update'])->name('cities.update');
    Route::get('cities/delete/{city}', [CityController::class, 'destroy'])->name('cities.destroy');

    // Films
    Route::get('films', [FilmController::class, 'index'])->name('films.index');
    Route::get('/cinemas/films/{cinema}', [FilmController::class, 'indexForACinema'])->name('films.cinema');
    Route::get('films/create', [FilmController::class, 'create'])->name('films.create');
    Route::post('films/store', [FilmController::class, 'store'])->name('films.store');
    Route::get('films/edit/{film}', [FilmController::class, 'edit'])->name('films.edit');
    Route::put('films/update/{film}', [FilmController::class, 'update'])->name('films.update');
    Route::get('films/delete/{film}', [FilmController::class, 'destroy'])->name('films.destroy');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('order/details', [OrderController::class, 'createClient'])->name('orders.details');
    Route::get('order/checkout', [OrderController::class, 'createByClient'])->name('orders.createByClient');
    Route::post('orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/edit/{order}', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/update/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('orders/delete/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Order Products
    Route::get('order-products', [OrderProductController::class, 'index'])->name('order-products.index');
    Route::get('order-products/create', [OrderProductController::class, 'create'])->name('order-products.create');
    Route::post('order-products/store', [OrderProductController::class, 'store'])->name('order-products.store');
    Route::get('order-products/edit/{order_product}', [OrderProductController::class, 'edit'])->name('order-products.edit');
    Route::put('order-products/update/{order_product}', [OrderProductController::class, 'update'])->name('order-products.update');
    Route::get('order-products/delete/{order_product}', [OrderProductController::class, 'destroy'])->name('order-products.destroy');

    // Order Tickets
    Route::get('order-tickets', [OrderTicketController::class, 'index'])->name('order-tickets.index');
    Route::get('order-tickets/create', [OrderTicketController::class, 'create'])->name('order-tickets.create');
    Route::post('order-tickets/store', action: [OrderTicketController::class, 'store'])->name('order-tickets.store');
    Route::get('order-tickets/edit/{order_ticket}', [OrderTicketController::class, 'edit'])->name('order-tickets.edit');
    Route::put('order-tickets/update/{order_ticket}', [OrderTicketController::class, 'update'])->name('order-tickets.update');
    Route::get('order-tickets/delete/{order_ticket}', [OrderTicketController::class, 'destroy'])->name('order-tickets.destroy');

    // Product Categories
    Route::get('product-categories', [ProductCategoryController::class, 'index'])->name('product-categories.index');
    Route::get('product-categories/create', [ProductCategoryController::class, 'create'])->name('product-categories.create');
    Route::post('product-categories/store', [ProductCategoryController::class, 'store'])->name('product-categories.store');
    Route::get('product-categories/edit/{product_category}', [ProductCategoryController::class, 'edit'])->name('product-categories.edit');
    Route::put('product-categories/update/{product_category}', [ProductCategoryController::class, 'update'])->name('product-categories.update');
    Route::get('product-categories/delete/{product_category}', [ProductCategoryController::class, 'destroy'])->name('product-categories.destroy');

    // Product Cinemas
    Route::get('product-cinemas', [ProductCinemaController::class, 'index'])->name('product-cinemas.index');
    Route::get('product-cinemas/create', [ProductCinemaController::class, 'create'])->name('product-cinemas.create');
    Route::post('product-cinemas/store', [ProductCinemaController::class, 'store'])->name('product-cinemas.store');
    Route::get('product-cinemas/edit/{product_cinema}', [ProductCinemaController::class, 'edit'])->name('product-cinemas.edit');
    Route::put('product-cinemas/update/{product_cinema}', [ProductCinemaController::class, 'update'])->name('product-cinemas.update');
    Route::get('product-cinemas/delete/{product_cinema}', [ProductCinemaController::class, 'destroy'])->name('product-cinemas.destroy');

    // Products
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{cinema}/{film}/{room}/{time}/products', [ProductController::class, 'indexBarProducts'])->name('products.chairs');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('products/delete/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Profiles
    Route::get('profiles', [ProfileController::class, 'index'])->name('profiles.index');
    Route::get('profiles/create', [ProfileController::class, 'create'])->name('profiles.create');
    Route::post('profiles/store', [ProfileController::class, 'store'])->name('profiles.store');
    Route::get('profiles/edit/{profile}', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('profiles/updateMyProfile/{profile}', [ProfileController::class, 'updateMyProfile'])->name('profiles.updateMyProfile');
    Route::put('profiles/update/{profile}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::get('profiles/delete/{profile}', [ProfileController::class, 'destroy'])->name('profiles.destroy');
    Route::get('/myProfile', [ProfileController::class, 'myProfile'])->name('profile.myProfile');

    // Rooms
    Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('rooms/store', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('rooms/edit/{room}', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('rooms/update/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::get('rooms/delete/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Temporal Reserves
    Route::get('temporal-reserves', [TemporalReserveController::class, 'index'])->name('temporal-reserves.index');
    Route::get('temporal-reserves/create', [TemporalReserveController::class, 'create'])->name('temporal-reserves.create');
    Route::post('temporal-reserves/store', [TemporalReserveController::class, 'store'])->name('temporal-reserves.store');
    Route::get('temporal-reserves/edit/{temporal_reserve}', [TemporalReserveController::class, 'edit'])->name('temporal-reserves.edit');
    Route::put('temporal-reserves/update/{temporal_reserve}', [TemporalReserveController::class, 'update'])->name('temporal-reserves.update');
    Route::get('temporal-reserves/delete/{temporal_reserve}', [TemporalReserveController::class, 'destroy'])->name('temporal-reserves.destroy');

    // Times
    Route::get('times', [TimeController::class, 'index'])->name('times.index');
    Route::get('/{cinema}/{film}/times', [TimeController::class, 'indexForAFilm'])->name('times.film');
    Route::get('times/create', [TimeController::class, 'create'])->name('times.create');
    Route::post('times/store', [TimeController::class, 'store'])->name('times.store');
    Route::get('times/edit/{time}', [TimeController::class, 'edit'])->name('times.edit');
    Route::put('times/update/{time}', [TimeController::class, 'update'])->name('times.update');
    Route::get('times/delete/{time}', [TimeController::class, 'destroy'])->name('times.destroy');

    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/update/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('users/delete/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
