<?php
namespace CrowsFeet\HttpLogger\Services;

use CrowsFeet\HttpLogger\Services\AbstractLoggerService;


class JsonResponseLoggerService extends AbstractLoggerService
{
    /**
     * 取得 Log 自定義標籤
     */
    protected function getTag()
    {
        return $this->getConfig('json_response.tag');
    }

    /**
     * 取得 LogData
     *
     * @param  mixed $source
     * @return string
     */
    protected function getLogData($source)
    {
        $data = [
            'header' => $source->headers->all(),
            'body' => $source->content()
        ];

        return $data;
    }
}
