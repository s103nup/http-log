<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    // 'api' => env('REQUEST_LOG_API', 'https://example.com.tw/api/save'),
    'level' => env('REQUEST_LOG_LEVEL', 4),
    'type' => env('REQUEST_LOG_TYPE', 'gw'),
    'tag' => env('REQUEST_LOG_TAG', 'request_logger'),
];
