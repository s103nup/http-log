## Laravel HTTP logger
This is a package to log HTTP request and JSON response with Laravel

## Installation
Require this package with composer.

```shell
composer require crows-feet/laravel-http-logger
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

Log request
```php
public function demo(Request $request)
{
    RequestLogger::log($request);
}
```

Log request with extra data
```php
public function demo(Request $request)
{
    $extra = [
        'RqID' => 'id',
    ];
    RequestLogger::log($request, $extra);
}
```

Log JSON response directly
```php
public function demo(JsonResponse $response)
{
    JsonResponseLogger::log($response);
}
```

Log JSON response with extra data
```php
public function demo(JsonResponse $response)
{
    $extra = [
        'RqID' => 'id',
    ];
    JsonResponseLogger::log($response, $extra);
}
```