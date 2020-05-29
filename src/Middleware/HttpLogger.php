<?php
namespace CrowsFeet\HttpLogger\Middleware;

	
use Closure;
use Illuminate\Support\Facades\Log;
use CrowsFeet\HttpLogger\Services\RequestLoggerService as RequestLogger;
use CrowsFeet\HttpLogger\Services\JsonResponseLoggerService as ResponseLogger;

class HttpLogger
{
    /**
     * Request Logger
     *
     * @var RequestLoggerService
     */
    protected $requestLogger;

    /**
     * Response Logger
     *
     * @var ResponseLoggerService
     */
    protected $responseLogger;

    public function __construct(
        RequestLogger $requestLogger,
        ResponseLogger $responseLogger
    ) {
        $this->requestLogger = $requestLogger;
        $this->responseLogger = $responseLogger;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->requestLogger->log($request);
        $rqid = $this->requestLogger->getRqid();
        Log::info('Request RqId: ' . $rqid);

        $response = $next($request);
        $this->responseLogger->log($response, $rqid);
        Log::info('Response RqId: ' . $rqid);

        return $response;
    }
}
