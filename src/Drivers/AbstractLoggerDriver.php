<?php
namespace CrowsFeet\HttpLogger\Drivers;

use CrowsFeet\HttpLogger\Drivers\LoggerDriverInterface;


abstract class AbstractLoggerDriver implements LoggerDriverInterface
{
    /**
     * 取得驅動名稱
     *
     * @return string
     */
    abstract protected function getDriverName();

    /**
     * 取得驅動設定
     *
     * @param string $name
     * @return string
     */
    protected function getConfig($name)
    {
        $configName = 'http_logger.drivers.' . $this->getDriverName() . '.' . $name;
        
        return config($configName);
    }
}