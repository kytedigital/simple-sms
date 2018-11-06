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
Route::group(['namespace' => 'Api', 'middleware' => ['api']], function () {
    Route::post('dispatch', 'MessageController@send');
    Route::get('message-channels', 'MessageController@availableChannels');
    Route::get('subscription', 'SubscriptionController@getSubscription');
    Route::get('subscription/statistics', 'SubscriptionController@getSubscriptionStatistics');
    Route::get('get-subscription', 'SubscriptionController@getSubscription');
    Route::get('customers', 'CustomersController@browse');
    Route::get('customers/search', 'CustomersController@search');
    Route::get('customers/{id}', 'CustomersController@read');
});
