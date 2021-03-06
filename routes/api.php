<?php

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Helpers\Shopify;

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


Route::group(['namespace' => 'Api', 'middleware' => 'auth.token'], function () {
    Route::post('dispatch', 'MessageController@send');
    Route::get('dispatch', function() {
        return ['message' => 'You can only post to this endpoint.'];
    });
    Route::get('message-channels', 'MessageController@availableChannels');
    Route::get('subscription', 'SubscriptionController@getSubscription');
    Route::get('customers', 'CustomersController@browse');
    Route::get('customers/search', 'CustomersController@search');
    Route::get('customers/{id}', 'CustomersController@read');

    Route::post('customers/redact', function(Request $request) {
        Log::info('Customer redact requested');
        Log::debug($request->all());
       return $request->all();
    });

    Route::post('customers/delete', function(Request $request) {
        Log::info('Customer delete requested');
        Log::debug($request->all());
        return $request->all();
    });


    Route::post('shop/delete', function(Request $request) {

        Log::info('Shop delete requested');
        Log::debug($request->all());

        return Shop::where(
            'name',
            '=',
            Shopify::stemName($request->get('shop_domain')))
            ->delete();
    });

});

Route::group(['namespace' => 'Api'], function () {
    Route::options('customers', function() { return response(''); });
    Route::options('dispatch', function() { return response(''); });
    Route::options('health', function() { return response(''); });
    Route::options('subscriptions', function() { return response(''); });
});
