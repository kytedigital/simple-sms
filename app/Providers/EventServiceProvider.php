<?php

namespace App\Providers;

use App\MessageLog;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('message.sent', function ($channel, $message, $shop) {

            $message['channel'] = $channel;
            $message['recipients'] = $message['to'];
            $message['shop'] = $shop;

            (new MessageLog($message))->save();

        });
    }
}
