<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\UserController;

/* -------------------------------------------------------------------------- */
/*                                   Article                                  */
/* -------------------------------------------------------------------------- */

Route::group(['middleware' => 'auth.token'], function(){
    Route::group(['prefix' => 'article'], function () {
        Route::post('create', [ArticleController::class, 'store']);
        Route::post('update/{id}', [ArticleController::class, 'update']);
        Route::delete('delete/{id}', [ArticleController::class, 'delete']);
        Route::post('data-table', [ArticleController::class, 'dataTable']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('create', [UserController::class, 'store']);
        Route::post('update/{id}', [UserController::class, 'update']);
        Route::delete('delete/{id}', [UserController::class, 'delete']);
        Route::post('data-table', [UserController::class, 'dataTable']);
    });
});