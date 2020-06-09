<?php
namespace CrowsFeet\HttpLogger\Traits;

use Illuminate\Support\Str;

trait RequestId
{
    /**
     * 取得 Request ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $name
     * @return string
     */
    protected function getRequestId($request, $name = '')
    {
        if ($name === '') {
            $name = config('http_logger.request_id_name');
        }
        return $request->input($name, $this->generateRequestId());
    }

    /**
     * 產生 Rqid
     *
     * @return string
     */
    protected function generateRequestId()
    {
        return (string) Str::uuid();
    }
}