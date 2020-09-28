<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
Route::get("/migrate", function () {
    Artisan::call("migrate:fresh --seed");
    dd("migrate");
});
Route::get("/key-generate", function () {
    Artisan::call("key:generate");
    dd("key-generated");
});
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Api', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::apiResource('news-category', 'CategoryController');
    Route::apiResource('news', 'NewsController');
    Route::apiResource('sub-category', 'SubCategoryController');
    Route::apiResource('news-tags', 'TagController');
    Route::match(['get', 'post'], 'setting', 'SettingController@setting')->name('setting');

});
Route::group(['namespace' => 'Api'], function () {

    Route::post('login', 'AuthController@authenticate');
    Route::post('register', 'AuthController@register');
});

Route::group(['namespace' => 'Api', 'middleware' => ['jwt.verify']], function () {
    Route::get('user', 'AuthController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
});
Route::group(['prefix' => 'admin', 'namespace' => 'APi'], function () {
    Route::get("/news/{type}/type/{category}/category", 'NewsController@getByType');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Api'], function () {
    Route::get('/ads', "AdsController@index")->name("api.ads");
    Route::get('/ads/{id}', "AdsController@show")->name("api.ads.show");
    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('/ads', "AdsController@store")->name("api.ads.create");
        Route::put('/ads/{id}', "AdsController@update")->name("api.ads.update");
        Route::delete('/ads/{id}', "AdsController@destroy")->name("api.ads.destroy");
    });
});
Route::group(['prefix' => 'admin', 'namespace' => 'Api'], function () {
    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('/contact', "ContactController@index")->name("api.contact");
        Route::put('/contact/{id}', "ContactController@update")->name("api.contact.update");
        Route::delete('/contact/{id}', "ContactController@destroy")->name("api.contact.destroy");
    });
    Route::post('/contact', "ContactController@store")->name("api.contact.create");
});
