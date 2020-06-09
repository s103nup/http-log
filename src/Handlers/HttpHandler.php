<?php declare(strict_types=1);

namespace CrowsFeet\HttpLogger\Handlers;


use CrowsFeet\HttpLogger\Jobs\HttpProcessor;
use Monolog\Handler\AbstractProcessingHandler;


class HttpHandler extends AbstractProcessingHandler
{
    /**
     *
     * @param array $record
     */
    protected function write(array $record): void
    {
        HttpProcessor::dispatch($this->getContent($record));
    }

    /**
     * 取得 Log 內容
     *
     * @param  array  $record
     * @return string
     */
    private function getContent($record)
    {
        return $record['message'];
    }
}
