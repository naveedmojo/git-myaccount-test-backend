<?php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
});

