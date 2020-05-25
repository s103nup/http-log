<?php
namespace CrowsFeet\HttpLogger\Drivers;

interface LoggerDriverInterface
{
    /**
     * 記錄 Log 方式
     *
     * @param  mixed  $content
     * @return mixed
     */
    public function handle($content);

    /**
     * 是否成功記錄 Log
     *
     * @param  boolean $return
     * @return boolean
     */
    public function isSuccess($return);
}