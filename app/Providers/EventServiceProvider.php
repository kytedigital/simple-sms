<?php

namespace App\Providers;

use App\MessageLog;
use Illuminate\Support\Facades\Event;
use App\Events\MessageDispatchCompleted;
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

        Event::listen(MessageDispatchCompleted::class, function ($event) {
            $message = (array) $event->message;
            $message['channel'] = $event->channel;
            $message['recipients'] = $message['recipient']['phone'];
            $message['shop'] = $event->shop;

            (new MessageLog($message))->save();
        });
    }
}
