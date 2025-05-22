<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1'], function (){
    Route::prefix('auth')->group(base_path('routes/modules/auth.php'));
    Route::prefix('user')->group(base_path('routes/modules/user.php'));
    Route::prefix('article')->group(base_path('routes/modules/article.php'));
    Route::prefix('reservation')->group(base_path('routes/modules/reservation.php'));
    Route::prefix('admin')->group(base_path('routes/modules/admin.php'));
     Route::prefix('categories')->group(base_path('routes/modules/categories.php'));
});

