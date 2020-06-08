## Laravel HTTP logger
This is a package to log HTTP request and JSON response with Laravel

## Installation
Require this package with composer.

```shell
composer require crows-feet/laravel-http-logger
```

Generate a migration and create it
```shell
php artisan queue:table

php artisan queue:failed-table

php artisan migrate
```

## Configuration
To copy the package config to Laravel with the following `publish` command
```shell
php artisan vendor:publish --tag="http-logger-config"
```

## Usage
To allow the logger for API routes, add the `HttpLogger` middleware to `app/Http/Kernel.php`:
```php
protected $middlewareGroups = [
    // ...
    'api' => [
        // ...
        \CrowsFeet\HttpLogger\Middleware\JsonApiLogger::class,
    ],
];
```

Start processing jobs on the queue as a daemon
```shell
nohup php artisan queue:work &
```

