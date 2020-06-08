<?php
namespace CrowsFeet\HttpLogger\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use CrowsFeet\HttpLogger\Jobs\AsyncLogProcessor;


abstract class AbstractLoggerService
{
    /**
     * Request ID
     *
     * @var string
     */
    protected $rqId = '';

    /**
     * 記錄 Log
     *
     * @param  mixed   $source
     * @param  string  $rqId
     * @return boolean
     */
    public function log($source, $rqId = '')
    {
        $this->setRqid($rqId);
        $this->dispatch($this->getContent($source));
    }

    /**
     * 產生 Rqid
     *
     * @return void
     */
    public function generateRqid()
    {
        return (string) Str::uuid();
    }

    /**
     * 取得 Rqid
     *
     * @return string
     */
    public function getRqid()
    {
        return $this->rqId;
    }
    
    /**
     * 取得 Log 內容
     *
     * @param  mixed  $source
     * @return array
     */
    protected function getContent($source)
    {
        return [
            'MID' => $this->getMerchantId($source),
            'RqID' => $this->getRqid(),
            'LevelID' => $this->getLevelId(),
            'Type' => $this->getProjectName(),
            'Tag' => $this->getTag(),
            'LogData' => $this->getLogData($source),
            'UserIP' => $this->getUserIp(),
            'UserAgent' => $this->getUserAgent(),
            'ProcessDate' => $this->getProcessDate(),
        ];
    }

    /**
     * 設定 Rqid
     *
     * @param  string $rqId
     * @return void
     */
    protected function setRqid($rqId)
    {
        if ($rqId === '') {
            $rqId = $this->generateRqid();
        }

        $this->rqId = $rqId;
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
     * 發送 Log
     *
     * @param  array $content
     * @return void
     */
    protected function dispatch($content)
    {
        AsyncLogProcessor::dispatch($content);
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

    /**
     * 取得 Merchant ID
     *
     * @param  mixed  $source
     * @return string
     */
    abstract public function getMerchantId($source);
}