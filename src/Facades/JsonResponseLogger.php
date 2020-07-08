<?php

namespace CrowsFeet\HttpLogger\Facades;

use Illuminate\Support\Facades\Facade;

class JsonResponseLogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'jsonResponseLogger';
    }
}
