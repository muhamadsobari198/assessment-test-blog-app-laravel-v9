<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleController;

/* -------------------------------------------------------------------------- */
/*                                   Article                                  */
/* -------------------------------------------------------------------------- */

Route::group(['middleware' => 'auth.token'], function(){
    Route::group(['prefix' => 'article'], function () {
        Route::post('create', [ArticleController::class, 'store']);
    });
});