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
        $driver = $this->getDriver();
        $this->app->singleton(RequestLoggerService::class, function ($app) use ($driver) {
            return new RequestLoggerService($driver);
        });

        $this->app->singleton(JsonResponseLoggerService::class, function ($app) use ($driver) {
            return new JsonResponseLoggerService($driver);
        });
    }

    /**
     * Get driver
     *
     * @return mixed
     */
    private function getDriver()
    {
        $driverName = ucfirst(config('http_logger.default', 'Http'));
        $container = 'CrowsFeet\HttpLogger\Drivers\\' . $driverName;

        return app($container);
    }
}
