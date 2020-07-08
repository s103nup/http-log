<?php
namespace CrowsFeet\HttpLogger\Middleware;

use CrowsFeet\HttpLogger\Middleware\AbstractRequestAndResponseLogger;

class JsonApiLogger extends AbstractRequestAndResponseLogger
{
    /**
     * 取得擴充資料
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function getExtra($request)
    {
        return  [];
    }

    /**
     * 取得 Request Logger
     *
     * @return array
     */
    protected function getRequestLogger()
    {
        return 'CrowsFeet\HttpLogger\Facades\RequestLogger';
    }

    /**
     * 取得 Response Logger
     *
     * @return array
     */
    protected function getResponseLogger()
    {
        return 'CrowsFeet\HttpLogger\Facades\JsonResponseLogger';
    }
}
