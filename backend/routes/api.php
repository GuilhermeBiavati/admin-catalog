<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {

    $expeptCreateAndEdit = ['except' => ['create', 'edit']];
    Route::resource('categories', 'CategoryController', $expeptCreateAndEdit);
    Route::resource('genres', 'GenreController', $expeptCreateAndEdit);
    Route::resource('cast_members', 'CastMemberController', $expeptCreateAndEdit);
    Route::resource('videos', 'VideoController', $expeptCreateAndEdit);
});
