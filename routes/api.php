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
    Route::apiResource('subscription', 'SubscriptionController')->only('show');
    Route::apiResource('plans', 'PlansController')->only('index');
});

Route::group(['namespace' => 'Api'], function () {
    Route::get('health', 'HealthController');
    Route::post('lifecycle/shopDelete', 'LifecycleWebhookController@shopDelete');
    Route::post('lifecycle/customersRedact', 'LifecycleWebhookController@customersRedact');
    Route::post('lifecycle/customersDelete', 'LifecycleWebhookController@customersDelete');
});
