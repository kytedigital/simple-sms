<?php

namespace App\Services\SendGrid;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the SendGrid client in the app container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {

            return new Client(
                config('services.sendgrid.key')
            );

        });
    }
}
