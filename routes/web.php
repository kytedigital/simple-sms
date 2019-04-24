<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['checkShop', 'checkHmac', 'redirectShopifyAppInstalls']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('subscription', 'SubscriptionController@view')->name('subscription');
    Route::get('create-subscription', 'SubscriptionController@createSubscription')
        ->name('subscription.make');
    Route::get('activate-subscription', 'SubscriptionController@activateSubscription')
        ->name('subscription.activate');

    Route::get('token', 'InstallationController')->middleware(['checkNounce']);
});

Route::get('health', function () { return response()->json(['status' => 200]); });
Route::get('contact',  'ContactController@index')->name('contact');
Route::get('refresh',  'SecurityController@refresh')->name('refresh');
Route::get('security', 'SecurityController@security')->name('security');
Route::get('error', 'ErrorController')->name('error');


Route::get('scheduler', function () {
    \Illuminate\Support\Facades\Artisan::call('schedule:run');
});