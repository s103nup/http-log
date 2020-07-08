<?php
namespace CrowsFeet\HttpLogger\Traits;

trait JsonResponse
{
    /**
     * 取得 JSON Response Header
     *
     * @param  JsonResponse $response
     * @return array
     */
    protected function getJsonResponseHeaders($response)
    {
        return $response->headers->all();
    }

    /**
     * 取得 JSON Response Body
     *
     * @param  JsonResponse $response
     * @return array
     */
    protected function getJsonResponseBody($response)
    {
        return $response->content();
    }
}
