<?php
namespace CrowsFeet\HttpLogger\Middleware;

	
use Closure;
use Illuminate\Support\Facades\Log;
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
        Log::info('Request RqId: ' . $requestLogger->getRqid());

        $responseLogger = app(JsonResponseLoggerService::class);
        $response = $next($request);
        $responseLogger->log($response);
        Log::info('Response RqId: ' . $responseLogger->getRqid());

        return $response;
    }
}
