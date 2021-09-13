<?php

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
        Route::group(['prefix' => 'contracts'], function () {
            Route::post('/upload', 'ContractController@upload')->name('contract.upload');
            Route::get('/', 'ContractController@index')->name('contract.index'); //note that this endpoint is also used for searching (?search=value)
            Route::get('/{id}/{status?}', 'ContractController@find')->name('contract.find');
        });
    }
);
