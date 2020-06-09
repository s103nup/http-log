<?php

namespace CrowsFeet\HttpLogger\Providers;

use Illuminate\Support\ServiceProvider;
use CrowsFeet\HttpLogger\Jobs\AsyncLogProcessor;
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
        $this->publishes([
            __DIR__ . '/../../config/http_logger.php' => config_path('http_logger.php'),
        ], 'http-logger-config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRequestLogger();

        $this->registerJsonResponseLogger();
    }

    /**
     * Register request logger
     *
     * @return void
     */
    private function registerRequestLogger()
    {
        $this->app->singleton('requestLogger', function ($app) {
            return new RequestLoggerService;
        });
    }

    /**
     * Register json response logger
     *
     * @return void
     */
    private function registerJsonResponseLogger()
    {
        $this->app->singleton('jsonResponseLogger', function ($app) {
            return new JsonResponseLoggerService;
        });
    }
}
