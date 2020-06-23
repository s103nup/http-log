<?php
namespace CrowsFeet\HttpLogger\Traits;

use Illuminate\Support\Str;

trait Request
{
    /**
     * 取得 Request ID
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $name
     * @return string
     */
    protected function getRequestId($request, $name = '')
    {
        return $request->input(
            $this->getRequestIdName($name),
            $this->generateRequestId()
        );
    }

    /**
     * Get request id name
     *
     * @param string $name
     * @return string
     */
    protected function getRequestIdName($name)
    {
        if ($name === '') {
            $name = config('http_logger.request_id_name');
        }

        return $name;
    }

    /**
     * 產生 Request ID
     *
     * @return string
     */
    protected function generateRequestId()
    {
        return (string) Str::uuid();
    }

    /**
     * 取得 User IP
     *
     * @return string
     */
    protected function getUserIp()
    {
        return request()->ip();
    }

    /**
     * 取得 User Agent
     *
     * @return string
     */
    protected function getUserAgent()
    {
        return request()->userAgent();
    }

    /**
     * 取得 Reqeust Header
     *
     * @return string
     */
    protected function getRequestHeaders()
    {
        return request()->headers->all();
    }

    /**
     * 取得 Request Body
     *
     * @return string
     */
    protected function getRequestBody()
    {
        return request()->all();
    }

    /**
     * Get request full URL
     *
     * @return string
     */
    protected function getRequestFullUrl()
    {
        return request()->fullUrl();
    }
}
