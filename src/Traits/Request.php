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
        $headerRequestId = $this->getRequestIdFromHeader($request, $name);
        if ($headerRequestId !== '') {
            return $headerRequestId;
        }
        
        $bodyRequestId = $this->getRequestIdFromBody($request, $name);
        if ($bodyRequestId !== '') {
            return $bodyRequestId;
        }

        return $this->generateRequestId();
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

    /**
     * Get request id from body
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $name
     * @return string
     */
    protected function getRequestIdFromBody($request, $name)
    {
        return $request->input(
            $this->getRequestIdName($name),
            ''
        );
    }

    /**
     * Get request id from header
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string                   $name
     * @return string
     */
    protected function getRequestIdFromHeader($request, $name)
    {
        if (isset($request->header()[$name])) {
            return $request->header()[$name][0];
        } else {
            return '';
        }
    }
}