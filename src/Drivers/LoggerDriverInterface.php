<?php
namespace CrowsFeet\HttpLogger\Drivers;

interface LoggerDriverInterface
{
    /**
     * 記錄 Log
     *
     * @param  mixed $content
     * @return void
     */
    public function log($content);
}