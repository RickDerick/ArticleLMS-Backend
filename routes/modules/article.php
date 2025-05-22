<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Article\ArticleController;


/*
|--------------------------------------------------------------------------
| Article Routes
|--------------------------------------------------------------------------

*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
    Route::get('/genres', [ArticleController::class, 'getGenres']);
});

