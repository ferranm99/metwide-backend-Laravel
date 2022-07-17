<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        'fortify/*',
        'api/v1/*',
        'sanctum/csrf-cookie',
        'user/two-factor-authentication',
        'user/two-factor-recovery-codes',
        'user/two-factor-qr-code',
        'user/confirm-password',
        'forgot-password',
        'login/reset-password',
        'user/profile-information',
        'user/update-two-factor-confirmed',
        'two-factor-challenge',
        'get-broadband-orders',
        'get-broadband-order',
        'get-nbn-services',
        'get-nbn-service',
        'get-subscriptions',
        'get-subscription',
        'get-user-online-status',
        'nbn-location-id-lookup',
        'get-network-statuses',
        'get-network-status',
        'get-invoices',
        'get-transactions',
        'get-broadband-orders-status',
        'get-nbn-services-status',
        'get-account-users',
    ],


    /*
    * Matches the request method. `[*]` allows all methods.
    */
    'allowed_methods' => ['*'],

    /*
     * Matches the request origin. `[*]` allows all origins.
     */
    'allowed_origins' => ['*'],

    /*
     * Matches the request origin with, similar to `Request::is()`
     */
    'allowed_origins_patterns' => [],

    /*
     * Sets the Access-Control-Allow-Headers response header. `[*]` allows all headers.
     */
    'allowed_headers' => ['*'],

    /*
     * Sets the Access-Control-Expose-Headers response header.
     */
    'exposed_headers' => [],

    /*
     * Sets the Access-Control-Max-Age response header.
     */
    'max_age' => 0,

    /*
     * Sets the Access-Control-Allow-Credentials header.
     */
    'supports_credentials' => true,




];
