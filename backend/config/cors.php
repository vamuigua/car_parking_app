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

    // Specifies which laravel route paths can accept cross-origin requests
    'paths' => ['*'],

    // What HTTP methods can be received i.e GET, POST, PUT, DELETE
    'allowed_methods' => ['*'],

    // What origins are allowed to send cross-origin requests to the laravel app
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:5173')],

    // Specifies a regex pattern that matches the origins that are allowed
    'allowed_origins_patterns' => [],

    // Which headers are allowed to be sent with cross-origin requests
    'allowed_headers' => ['*'],

    // Which headers are exposed to clients
    'exposed_headers' => [],

    // How long the results of a preflight request can be cached
    'max_age' => 0,

    // Tells the laravel app to share cookies with the clients e.g SPAs
    'supports_credentials' => true,

];
