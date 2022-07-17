<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'vocus' => [
        'key_password' => env('VOCUS_KEY_PASSWORD'),
        'access_key' => env('VOCUS_ACCESS_KEY'),
        'dev_key_password' => env('VOCUS_DEV_KEY_PASSWORD'),
        'dev_access_key' => env('VOCUS_DEV_ACCESS_KEY'),
        'vocus_test' => env('VOCUS_TEST'),
    ],
    'opticomm' => [
        'username' => env('OPTICOMM_USERNAME'),
        'password' => env('OPTICOMM_PASSWORD'),
        'endpoint' => env('OPTICOMM_ENDPOINT'),
        'wsdl' => env('OPTICOMM_WSDL'),
    ],
    'commweb' => [
        'alp' => [
            'password' => env('ALP_COMMWEB_PASSWORD'),
            'merchantid' => env('ALP_COMMWEB_MERCHANTID'),
        ],
        'mwc' => [
            'password' => env('MWC_COMMWEB_PASSWORD'),
            'merchantid' => env('MWC_COMMWEB_MERCHANTID'),
        ],
        'mwd' => [
            'password' => env('MWD_COMMWEB_PASSWORD'),
            'merchantid' => env('MWD_COMMWEB_MERCHANTID'),
        ],
        'wsc' => [
            'password' => env('WSC_COMMWEB_PASSWORD'),
            'merchantid' => env('WSC_COMMWEB_MERCHANTID'),
        ],
        'token_test' => env('TOKEN_TEST'),
    ],
    'aapt' => [
        'pass_phrase' => env('AAPT_PASS_PHRASE'),
        'pass_phrase_test' => env('AAPT_PASS_PHRASE_TEST'),
    ],
    'site' => [
        'code' => env('SITE_CODE'),
        'name' => env('SITE_NAME'),
        'domain' => env('SITE_DOMAIN'),
        'email_domain' => env('SITE_EMAIL_DOMAIN'),
        'address' => env('SITE_ADDRESS'),
    ],

];
