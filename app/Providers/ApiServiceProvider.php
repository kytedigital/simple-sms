<?php

namespace App\Providers;

use App\Http\State;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindRepositories();
    }

    private function bindRepositories()
    {
        $this->app->bind('App\Repositories\Shopify\CustomersRepositoryInterface',
                         'App\Repositories\Shopify\CustomersRepository');

        $this->app->bind('App\Http\State', function()  {
            return new State;
        });
    }
}
