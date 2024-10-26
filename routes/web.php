<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ShortUrlController;

// Guest routes group
Route::middleware(['guest'])->group(function () {
    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Authenticated routes group
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    // Links Management
    Route::post('/links', [LinkController::class, 'store'])
        ->name('links.store');
    Route::put('/links/{link}', [LinkController::class, 'update'])
        ->name('links.update');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])
        ->name('links.destroy');

    // Short URLs Management (protected routes)
    Route::post('/short-urls', [ShortUrlController::class, 'store'])
        ->name('short-urls.store');
    Route::delete('/short-urls/{shortUrl}', [ShortUrlController::class, 'destroy'])
        ->name('short-urls.destroy');
});

// Public short URL redirect (no auth required)
Route::get('/s/{shortCode}', [ShortUrlController::class, 'redirect'])
    ->name('short-urls.redirect');

// Public users URL view
Route::get('/{username}', [LinkController::class, 'profile'])
    ->name('links.profile');

// Home page redirect
Route::permanentRedirect('/', '/dashboard');