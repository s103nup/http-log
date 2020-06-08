<?php
namespace CrowsFeet\HttpLogger\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use CrowsFeet\HttpLogger\Drivers\LoggerDriverInterface;

class AsyncLogProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Log 內容
     *
     * @var array
     */
    protected $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LoggerDriverInterface $driver)
    {
        $driver->log($this->content);
    }
}
