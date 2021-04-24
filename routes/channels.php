<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
use Illuminate\Http\Request;

Broadcast::channel('shop.{shop}', function ($user, $shop) {
    dd(app(Request::class)->get('shop'), $shop);
    return $shop === app(Request::class)->get('shop');
});
