<?php
namespace CrowsFeet\HttpLogger\Middleware;

	
use Closure;
use Illuminate\Support\Facades\Log;

class JsonApiLogger
{
    /**
     * Request logger
     *
     * @var AbstractLoggerService
     */
    protected $requestLogger;

    /**
     * Request logger
     *
     * @var AbstractLoggerService
     */
    protected $responseLogger;

    public function __construct()
    {
        $this->requestLogger = $this->getRequestLogger();
        $this->responseLogger = $this->getResponseLogger();
    }

    /**
     * Get request logger
     *
     * @return string
     */
    private function getRequestLogger()
    {
        return 'CrowsFeet\HttpLogger\Facades\RequestLogger';
    }

    /**
     * Get response logger
     *
     * @return string
     */
    private function getResponseLogger()
    {
        return 'CrowsFeet\HttpLogger\Facades\JsonResponseLogger';
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
        $this->logRequest($request);

        $response = $next($request);

        $this->logResponse($request, $response);

        return $response;
    }

    /**
     * 記錄 Request
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    private function logRequest($request)
    {
        $this->requestLogger::log($request);
        $rqid = $this->requestLogger::getRqid();
        Log::info('Request RqId: ' . $rqid);
    }

    /**
     * 記錄回應
     *
     * @param \Illuminate\Http\Request  $request
     * @param mixed $response
     * @return void
     */
    private function logResponse($request, $response)
    {
        $merchantId = $this->requestLogger::getMerchantId($request);
        $this->responseLogger::setMerchantId($merchantId);
        
        $rqid = $this->requestLogger::getRqid();
        $this->responseLogger::log($response, $rqid);
    }
}
