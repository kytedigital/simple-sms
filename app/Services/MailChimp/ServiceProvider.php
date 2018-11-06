<?php

namespace App\Services\MailChimp;

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
     * Register the Shopify client in the app container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function () {

            return new Client(
                config('services.mailchimp.data_center'),
                config('services.mailchimp.api_user'),
                config('services.mailchimp.api_key')
            );

        });
    }
}
