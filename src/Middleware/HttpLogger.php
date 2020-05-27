<?php
namespace CrowsFeet\HttpLogger\Middleware;

	
use Closure;
use CrowsFeet\HttpLogger\Services\RequestLoggerService;
use CrowsFeet\HttpLogger\Services\JsonResponseLoggerService;

class HttpLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestLogger = app(RequestLoggerService::class);
        $requestLogger->log($request);

        $responseLogger = app(JsonResponseLoggerService::class);
        $response = $next($request);
        $responseLogger->log($response);

        return $response;
    }
}
