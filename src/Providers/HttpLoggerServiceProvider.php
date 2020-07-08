<?php

namespace CrowsFeet\HttpLogger\Providers;

use Illuminate\Support\ServiceProvider;
use CrowsFeet\HttpLogger\Services\RequestLoggerService;
use CrowsFeet\HttpLogger\Services\JsonResponseLoggerService;

class HttpLoggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
            __DIR__ . '/../../config/http_logger.php' => config_path('http_logger.php'),
            ],
            'http-logger-config'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerJsonApiLogger();
    }

    /**
     * Register Json api logger
     *
     * @return void
     */
    private function registerJsonApiLogger()
    {
        $this->app->singleton(
            'requestLogger',
            function ($app) {
                return new RequestLoggerService;
            }
        );

        $this->app->bind(
            'jsonResponseLogger',
            function ($app) {
                return new JsonResponseLoggerService;
            }
        );
    }
}
