<?php

namespace App\Services;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class MessagingServicesProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $enabled_services;

    /**
     * MessagingServicesProvider constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->enabled_services = config('services.messaging.channels');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('message_service_enabled', function ($attribute, $value, $parameters, $validator) {
            if(is_array($value)) {
                if(!count($disabled = array_diff($value, $this->enabled_services))) return true;
            }

            return in_array($value, $this->enabled_services);
        },
            "At lest one of the requested channels is not available for messaging. 
            Available channels include: ". implode(', ', $this->enabled_services));
    }

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
