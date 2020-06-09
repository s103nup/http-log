<?php
namespace CrowsFeet\HttpLogger\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class HttpProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Log 內容
     *
     * @var string
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
    public function handle()
    {
        $request = $this->getRequest($this->content);
        $this->send($request);
    }

    /**
     * 取得 HTTP request
     *
     * @param  string   $content
     * @return Request
     */
    private function getRequest($content)
    {
        return new Request(
            $this->getMethod(),
            $this->getConfig('url'),
            $this->getHeader(),
            $content
        );
    }

    /**
     * 取得 HTTP method
     *
     * @return string
     */
    private function getMethod()
    {
        return 'POST';
    }

    /**
     * 取得設定
     *
     * @param  string $name
     * @return string
     */
    private function getConfig($name)
    {
        $configName = 'http_logger.processor.http.' . $name;

        return config($configName);
    }

    /**
     * 取得 HTTP header
     *
     * @return array
     */
    private function getHeader()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getConfig('token'),
        ];
    }

    /**
     * 送出 Request
     *
     * @param  Request $request
     * @return void
     */
    private function send($request)
    {
        $client = new Client;
        $options = ['timeout' => 2];

        $client->send($request, $options);
    }
}
