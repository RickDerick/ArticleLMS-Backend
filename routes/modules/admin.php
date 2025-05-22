<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\User\UserController;
    use App\Http\Controllers\Article\ArticleController;


    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::post('/articles', [ArticleController::class, 'store']);
        Route::put('/articles/{id}', [ArticleController::class, 'update']);
        Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);
    });

// ?>