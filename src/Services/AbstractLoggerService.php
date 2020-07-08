<?php
namespace CrowsFeet\HttpLogger\Services;

use Illuminate\Support\Facades\Log;

abstract class AbstractLoggerService
{
    /**
     * 取得 Log Channel
     *
     * @return string
     */
    protected function getChannel()
    {
        return config('logging.default');
    }

    /**
     * 記錄 Log
     *
     * @param  mixed $source
     * @param  array $extra
     * @return boolean
     */
    public function log($source, $extra = [])
    {
        $content = $this->getContent($source, $extra);
        $log = $this->formate($content);

        Log::channel($this->getChannel())->info($log);
    }

    /**
     * Log 格式轉換
     *
     * @param  array $content
     * @return mixed
     */
    protected function formate($content)
    {
        return json_encode($content);
    }

    /**
     * 取得 Log 內容
     *
     * @param  mixed $source
     * @param  array $extra
     * @return array
     */
    abstract protected function getContent($source, $extra = []);
}
