<?php
namespace CrowsFeet\HttpLogger\Middleware;

use Closure;

abstract class AbstractRequestAndResponseLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $extra = $this->getExtra($request);
        $this->getRequestLogger()::log($request, $extra);

        $response = $next($request);
        $this->getResponseLogger()::log($response, $extra);

        return $response;
    }

    /**
     * 取得擴充資料
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    abstract protected function getExtra($request);

    /**
     * 取得 Request Logger
     *
     * @return array
     */
    abstract protected function getRequestLogger();

    /**
     * 取得 Response Logger
     *
     * @return array
     */
    abstract protected function getResponseLogger();
}
