<?php

use App\Http\Controllers\Api\V2\CategoryController;
use App\Http\Controllers\Api\V2\ProductController;

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::apiResource('categories', CategoryController::class);

    Route::get('products', [ProductController::class, 'index'])
    ->middleware('throttle:products');
});
