<?php

namespace CrowsFeet\HttpLogger\Facades;

use Illuminate\Support\Facades\Facade;

class RequestLogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'requestLogger';
    }
}
