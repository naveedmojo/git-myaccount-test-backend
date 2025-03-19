<?php

use App\Http\Controllers\AdminAuthController;

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Products Section
        Route::get('/products', function () {
            return view('admin.products');
        })->name('admin.products');

        // Categories Section
        Route::get('/categories', function () {
            return view('admin.categories');
        })->name('admin.categories');

        // Messages Section
        Route::get('/messages', function () {
            return view('admin.messages');
        })->name('admin.messages');

        // Reports Section
        Route::get('/reports', function () {
            return view('admin.reports');
        })->name('admin.reports');
    });
});
