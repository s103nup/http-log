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
        $this->registerAsyncLogProcessor();

        $this->registerRequestLogger();

        $this->registerJsonResponseLogger();
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

    /**
     * Register asynchronous processor
     * 
     * @return void
     */
    private function registerAsyncLogProcessor()
    {
        $driver = $this->getDriver();
        $this->app->bindMethod(AsyncLogProcessor::class.'@handle', function ($job, $app) use ($driver) {
            return $job->handle($driver);
        });
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
