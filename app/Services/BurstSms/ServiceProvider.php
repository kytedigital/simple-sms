<?php

namespace App\Services\BurstSms;

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
     * Register the BurstSms client in the app container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {
            return new Client(
                config('services.burstsms.api_key'),
                config('services.burstsms.api_secret'),
                config('services.burstsms.api_base')
            );
        });
    }
}
