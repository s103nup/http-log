<?php
namespace CrowsFeet\HttpLogger\Traits;

use Carbon\Carbon;

trait LogContent
{
    /**
     * 取得 Log 處理時間 timestamp
     *
     * @return int
     */
    protected function getProcessTimestamp()
    {
        return Carbon::now()->timestamp;
    }

    /**
     * 取得 Log 處理時間
     *
     * @return int
     */
    protected function getProcessDate()
    {
        return Carbon::now()->toDateTimeString();
    }
}