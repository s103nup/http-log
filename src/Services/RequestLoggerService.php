<?php
namespace CrowsFeet\HttpLogger\Services;

use CrowsFeet\HttpLogger\Services\AbstractLoggerService;


class RequestLoggerService extends AbstractLoggerService
{
    /**
     * 取得 Log 自定義標籤
     */
    protected function getTag()
    {
        return $this->getConfig('tag.request');
    }

    /**
     * 取得 LogData
     *
     * @param  mixed $source
     * @return string
     */
    protected function getLogData($source)
    {
        return json_encode($source->all());
    }

    /**
     * 取得 Merchant ID
     *
     * @param  mixed  $source
     * @return string
     */
    public function getMerchantId($source)
    {
        return $source->input('MerchantID', '');
    }
}
