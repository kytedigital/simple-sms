<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| ApiService Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ApiService routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your ApiService!
|
*/
Route::group(['namespace' => 'Api'], function () {
    Route::post('dispatch', 'MessageController@send');
    Route::get('dispatch', function() {
        return ['message' => 'You can only post to this endpoint.'];
    });
    Route::get('message-channels', 'MessageController@availableChannels');
    Route::get('subscription', 'SubscriptionController@getSubscription');
    Route::get('customers', 'CustomersController@browse');
    Route::get('customers/search', 'CustomersController@search');
    Route::get('customers/{id}', 'CustomersController@read');
});
