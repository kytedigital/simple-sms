<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

//    'shopify' => [
//        'app_api_key' => env('SHOPIFY_APP_API_KEY'),
//        'app_api_secret' => env('SHOPIFY_APP_API_SECRET'),
//    ],

    'shopify' => [
        'app_api_key' => env('SHOPIFY_APP_API_KEY'),
        'app_api_secret' => env('SHOPIFY_APP_API_SECRET'),
    ],

    'burstsms' => [
        'api_key' => env('BURST_SMS_API_KEY'),
        'api_secret' => env('BURST_SMS_API_SECRET'),
        'api_base' => env('BURST_SMS_API_BASE'),
        'backup_msisdn' => env('BURST_SMS_BACKUP_MSISDN')
    ],

    'mailchimp' => [
        'data_center' => env('MAILCHIMP_DATA_CENTER'),
        'api_user' => env('MAILCHIMP_API_USER'),
        'api_key' => env('MAILCHIMP_API_KEY'),
    ],

    'simple' => [
        'api_base' => env('API_BASE')
    ]

];
