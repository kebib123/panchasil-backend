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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Api', 'prefix' => 'admin', 'as' => 'admin.','middleware' => ['jwt.verify']], function () {
    Route::apiResource('news-category','CategoryController');
    Route::apiResource('news','NewsController');
});
Route::group(['namespace' => 'Api',], function () {

    Route::post('login', 'AuthController@authenticate');
    Route::post('register', 'AuthController@register');
});

Route::group(['namespace' => 'Api','middleware' => ['jwt.verify']], function() {
    Route::get('user', 'AuthController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
});
