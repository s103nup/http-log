<?php

namespace CrowsFeet\HttpLogger\Providers;

use Illuminate\Support\ServiceProvider;
use CrowsFeet\HttpLogger\Services\RequestLoggerService;
use CrowsFeet\HttpLogger\Services\JsonResponseLoggerService;

class HttpLoggerServiceProvider extends ServiceProvider
{
    /**
     * Is service provider loading defered
     *
     * @var boolean
     */
    protected $defer = true;

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
        $driver = config('http_logger.default');
        $container = 'CrowsFeet\HttpLogger\Drivers\\' . $driver;
        $this->app->singleton(RequestLoggerService::class, function ($app) use ($container) {
            $driver = app($container);

            return new RequestLoggerService($driver);
        });

        $this->app->singleton(JsonResponseLoggerService::class, function ($app) use ($container) {
            $driver = app($container);

            return new JsonResponseLoggerService($driver);
        });
    }
}
