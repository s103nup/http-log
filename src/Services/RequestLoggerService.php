<?php
namespace CrowsFeet\HttpLogger\Services;

use CrowsFeet\HttpLogger\Traits\Request;
use CrowsFeet\HttpLogger\Traits\LogContent;
use CrowsFeet\HttpLogger\Services\AbstractLoggerService;


class RequestLoggerService extends AbstractLoggerService
{
    use Request, LogContent;

    /**
     * 取得 Log 內容
     *
     * @param  mixed  $source
     * @param  array  $extra
     * @return string
     */
    protected function getContent($source, $extra = [])
    {
        $main = [
            'Type' => 'Request',
            'Header' => $this->getRequestHeaders(),
            'Body' => $this->getRequestBody(),
            'UserIp' => $this->getUserIp(),
            'UserAgent' => $this->getUserAgent(),
            'ProcessDate' => $this->getProcessDate(),
        ];

        return array_merge($main, $extra);
    }
}