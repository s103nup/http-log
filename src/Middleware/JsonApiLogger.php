<?php
namespace CrowsFeet\HttpLogger\Middleware;

	
use Closure;
use CrowsFeet\HttpLogger\Traits\RequestId;
use CrowsFeet\HttpLogger\Traits\MerchantId;
use CrowsFeet\HttpLogger\Facades\RequestLogger;
use CrowsFeet\HttpLogger\Facades\JsonResponseLogger;

class JsonApiLogger
{
    use RequestId, MerchantId;
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
        RequestLogger::log($request, $extra);

        $response = $next($request);
        JsonResponseLogger::log($response, $extra);

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
            'RqID' => $this->getRequestId($request),
            'MID' => $this->getMerchantId($request),
        ];
    }
}
