<?php
namespace CrowsFeet\HttpLogger\Middleware;

	
use Closure;
use Illuminate\Support\Str;
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
        $extra = $this->getExtra($request);
        $this->requestLogger::log($request, $extra);

        $response = $next($request);
        $this->responseLogger::log($response, $extra);

        return $response;
    }

    /**
     * 取得擴充資料
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getExtra($request)
    {
        return  [
            'RqID' => $this->getRqid($request),
            'MID' => $this->getMerchantId($request),
        ];
    }

    /**
     * 取得 Rqid
     *
     * @return string
     */
    private function getRqid($request)
    {
        return $request->input('RqId', $this->generateRqid());
    }

    /**
     * 產生 Rqid
     *
     * @return void
     */
    private function generateRqid()
    {
        return (string) Str::uuid();
    }

    /**
     * 取得 Merchant ID
     *
     * @param  mixed  $source
     * @return string
     */
    private function getMerchantId($source)
    {
        return $source->input('MerchantID', '9999999');
    }
}
