<?php

use Illuminate\Http\Request;
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

Route::group(
    ['prefix' => 'v1', 'namespace' => 'App\Http\Controllers'],
    function () {
        Route::group(['prefix' => 'users'], function () {
            Route::post('/register', 'UserController@register')->name('users.register');
            Route::post('/login', 'UserController@login')->name('users.login');

            Route::group(['middleware' => ['auth:sanctum']], function () {
                Route::get('/meals/recommendations', 'UserController@mealRecommendations')->name('users.meals.recommendation');
            });
        });

        Route::group(['prefix' => 'allergies', 'middleware' => ['auth:sanctum']], function () {
            Route::get('/', 'AllergyController@index')->name('allergies.index');
            Route::post('/', 'AllergyController@store')->name('allergies.store');
        });

        Route::group(['prefix' => 'meals'], function () {
            Route::get('/', 'MealController@index')->name('meals.index');
            Route::get('/{id}', 'MealController@find')->name('meals.find');
            Route::post('/recommendations', 'MealController@recommendations')->name('meals.recommendations');
        });
    }
);
