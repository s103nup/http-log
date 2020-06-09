<?php
namespace CrowsFeet\HttpLogger\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


abstract class AbstractLoggerService
{
    /**
     * 記錄 Log
     *
     * @param  mixed   $request
     * @param  array   $extra
     * @return boolean
     */
    public function log($request, $extra = [])
    {	
        $content = $this->getContent($request, $extra);
        $log = $this->toLog($content);
        Log::channel('http')->info($log);
    }

    /**
     * 取得 Log 內容
     *
     * @param  mixed  $request
     * @param  array  $extra
     * @return string
     */
    protected function getContent($request, $extra = [])
    {
        $main = [
            'LevelID' => $this->getLevelId(),
            'Type' => $this->getProjectName(),
            'Tag' => $this->getTag(),
            'LogData' => $this->getLogData($request),
            'UserIP' => $this->getUserIp(),
            'UserAgent' => $this->getUserAgent(),
            'ProcessDate' => $this->getProcessDate(),
        ];

        return array_merge($main, $extra);
    }

    /**
     * 轉為 Log
     *
     * @param  array  $content
     * @return string
     */
    protected function toLog($content)
    {
        return json_encode($content);
    }

    /**
     * 取得 Log 使用者 IP
     *
     * @return string
     */
    protected function getUserIp()
    {
        return request()->ip();
    }

    /**
     * 取得 Log 使用者 Agent
     *
     * @return string
     */
    protected function getUserAgent()
    {
        return request()->userAgent();
    }

    /**
     * 取得 Log 處理時間
     *
     * @return int
     */
    protected function getProcessDate()
    {
        return Carbon::now()->timestamp;
    }

    /**
     * 取得設定
     *
     * @param  string $name
     * @return mixed
     */
    protected function getConfig($name)
    {
        return config('http_logger.' . $name);
    }

    /**
     * 取得 Log 等級 ID
     *
     * @return string
     */
    protected function getLevelId()
    {
        return $this->getConfig('level_id');
    }

    /**
     * 取得 Log 專案名稱
     *
     * @return string
     */
    protected function getProjectName()
    {
        return $this->getConfig('project_name');
    }

    /**
     * 取得 Log 自定義標籤
     */
    abstract protected function getTag();

    /**
     * 取得 LogData
     *
     * @param  mixed $source
     * @return string
     */
    abstract protected function getLogData($source);
}