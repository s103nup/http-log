<?php
namespace CrowsFeet\HttpLogger\Services;

use CrowsFeet\HttpLogger\Traits\Request;
use CrowsFeet\HttpLogger\Traits\LogContent;
use CrowsFeet\HttpLogger\Traits\JsonResponse;
use CrowsFeet\HttpLogger\Services\AbstractLoggerService;

class JsonResponseLoggerService extends AbstractLoggerService
{
    use JsonResponse, Request, LogContent;

    /**
     * 取得 Log 內容
     *
     * @param  mixed $source`
     * @param  array $extra
     * @return string
     */
    protected function getContent($source, $extra = [])
    {
        $main = [
            'Type' => 'Response',
            'Header' => $this->getJsonResponseHeaders($source),
            'Body' => $this->getJsonResponseBody($source),
            'UserIp' => $this->getUserIp(),
            'UserAgent' => $this->getUserAgent(),
            'ProcessDate' => $this->getProcessDate(),
        ];

        return array_merge($main, $extra);
    }
}
