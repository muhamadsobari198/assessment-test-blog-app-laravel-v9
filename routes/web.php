<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleController;

Route::group(['prefix' => 'admin'], function () {
    Route::get('articles', [ArticleController::class, 'main'])->name('articles');
});