<?php
namespace CrowsFeet\HttpLogger\Traits;

use Illuminate\Support\Str;

trait Request
{
    /**
     * Get Request ID
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
     * Generate Request ID
     *
     * @return string
     */
    protected function generateRequestId()
    {
        return (string) Str::uuid();
    }

    /**
     * Get User IP
     *
     * @return string
     */
    protected function getUserIp()
    {
        return request()->ip();
    }

    /**
     * Get User Agent
     *
     * @return string
     */
    protected function getUserAgent()
    {
        return request()->userAgent();
    }

    /**
     * Get Reqeust Header
     *
     * @return string
     */
    protected function getRequestHeaders()
    {
        return request()->headers->all();
    }

    /**
     * Get Request Body
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
