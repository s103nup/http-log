<?php
namespace CrowsFeet\HttpLogger\Services;

use CrowsFeet\HttpLogger\Services\AbstractLoggerService;


class JsonResponseLoggerService extends AbstractLoggerService
{
    /**
     * Merchant ID
     *
     * @var string
     */
    protected $merchantId;

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
        return $source->content();
    }

    /**
     * 取得 Merchant ID
     *
     * @param  mixed  $source
     * @return string
     */
    public function getMerchantId($source)
    {
        return $this->merchantId;
    }

    /**
     * 設定 Merchant ID
     *
     * @param  string $merchantId
     * @return void
     */
    public function setMerchantId($merchantId)
    {
        if ($merchantId === '') {
            $this->merchantId = '9999999';
        }
        $this->merchantId = $merchantId;
    }
}
