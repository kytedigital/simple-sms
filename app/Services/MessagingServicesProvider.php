<?php

namespace App\Services;

use Illuminate\Support\ServiceProvider;

class MessagingServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->registerDeferredProvider(BurstSms\ServiceProvider::class);
        $this->app->registerDeferredProvider(MailChimp\ServiceProvider::class);
    }
}
