<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Site Key
    |--------------------------------------------------------------------------
    |
    | The site key is used to invoke reCAPTCHA service.
    |
    */

    'site_key' => env('RECAPTCHA_SITE_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Secret Key
    |--------------------------------------------------------------------------
    |
    | The secret key authorizes communication between your application backend
    | and the reCAPTCHA server.
    |
    */

    'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | PHPUnit testing
    |--------------------------------------------------------------------------
    |
    | During testing recaptcha cannot be used, setting this to true will skip
    | the recaptcha rule and return true.
    |
    */

    'testing' => env('RECAPTCHA_PHPUNIT_TESTS', false),
];
