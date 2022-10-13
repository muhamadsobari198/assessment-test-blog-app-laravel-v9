<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ArticleController;


/* -------------------------------------------------------------------------- */
/*                               Article Content                              */
/* -------------------------------------------------------------------------- */
Route::get('/', [ArticleController::class, 'index']);



/* -------------------------------------------------------------------------- */
/*                                    Auth                                    */
/* -------------------------------------------------------------------------- */

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'onLogin']);
Route::get('logout', [AuthController::class, 'onLogout'])->name('logout');
Route::get('verify-token/{token}', [AuthController::class, 'verifyToken']);


/* -------------------------------------------------------------------------- */
/*                                  Admin Panel                               */
/* -------------------------------------------------------------------------- */
Route::group(['middleware' => 'admin'], function(){
    Route::group(['prefix' => 'admin'], function () {
        Route::get('articles', [ArticleController::class, 'main'])->name('articles');
    });
});