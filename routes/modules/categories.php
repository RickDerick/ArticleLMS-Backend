<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Categories\CategoriesController;


/*
|--------------------------------------------------------------------------
| Categories Routes
|--------------------------------------------------------------------------

*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categories-setup', [CategoriesController::class, 'index']);
});

