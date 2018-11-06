<?php

namespace App\Factories;

class ChannelFactory
{

    /**
     * @var array
     */
    protected $channels = [];

    /**
     *
     */
    public function getChannel($channel)
    {



    }



    protected function registerChannels()
    {

        return [

          'sms' => App\Services\BurstSms\Client::class


        ];

    }


}