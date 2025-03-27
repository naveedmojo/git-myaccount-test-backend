<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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
        Route::prefix('products')->group(function () {
            Route::get('/', function () {
                return view('admin.products');
            })->name('admin.products');
            Route::get('/products',[ProductController::class,'index'])->name('admin.products.index');
            Route::post('/products/create',[ProductController::class,'store'])->name('admin.products.store');
            Route::post('/product/update/{id}',[ProductController::class,'update'])->name('admin.products.update');
        });

        // Categories Section
        Route::prefix('categories')->group(function () {
            Route::get('/', function () {
                return view('admin.categories');
            })->name('admin.categories');

            Route::get('/main', [CategoryController::class, 'mainindex'])->name('admin.maincategories.index'); // Get all main categories
            Route::post('/main/store', [CategoryController::class, 'mainstore'])->name('admin.maincategories.store'); // Create main category
            Route::post('/main/update/{id}', [CategoryController::class, 'mainupdate'])->name('admin.maincategories.update'); // Update main category
            Route::delete('/main/delete/{id}', [CategoryController::class, 'maindestroy'])->name('admin.maincategories.delete'); // Delete main category
            Route::get('/sub', [CategoryController::class, 'subindex'])->name('admin.subcategories.index');
            Route::Post('/sub/store', [CategoryController::class, 'substore'])->name('admin.subcategories.store');
            Route::post('/sub/update/{id}', [CategoryController::class, 'subupdate'])->name('admin.subcategories.update');
            Route::delete('/sub/delete/{id}', [CategoryController::class, 'subdestroy'])->name('admin.subcategories.destroy');


        });

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
