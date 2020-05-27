<?php
namespace CrowsFeet\HttpLogger\Services;

use Carbon\Carbon;
use CrowsFeet\HttpLogger\Drivers\LoggerDriverInterface;


abstract class AbstractLoggerService
{
    /**
     * Log 驅動
     *
     * @var LoggerDriver
     */
    protected $driver;

    /**
     * Request ID
     *
     * @var string
     */
    protected $rqId = '';

    public function __construct(LoggerDriverInterface $driver)
    {
        $this->driver = $driver;
    }
    
    /**
     * 取得 Log 內容
     *
     * @param  mixed  $source
     * @return string
     */
    protected function getContent($source)
    {
        $this->generateRqid();

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
     * 取得 Merchant ID
     *
     * @param  mixed  $source
     * @return string
     */
    abstract protected function getMerchantId($source);

    /**
     * 產生 Guid
     *
     * @return string
     */
    protected function generateGuid()
    {
        mt_srand((double)microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8)
            .substr($charid, 8, 4)
            .substr($charid, 12, 4)
            .substr($charid, 16, 4)
            .substr($charid, 20, 12);

        return $uuid;
    }

    /**
     * 產生 Rqid
     *
     * @return void
     */
    protected function generateRqid()
    {
        $this->rqId = $this->generateGuid();
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
     * 記錄 Log
     *
     * @param  mixed $source
     * @return boolean
     */
    public function log($source)
    {
        $content = $this->getContent($source);

        return $this->driver->log($content);
    }
}