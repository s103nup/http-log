<?php
namespace CrowsFeet\HttpLogger\Drivers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Response;
use CrowsFeet\HttpLogger\Drivers\AbstractLoggerDriver;

class Http extends AbstractLoggerDriver
{
    /**
     * 記錄 Log 方式
     *
     * @param  mixed  $content
     * @return mixed
     */
    public function handle($content)
    {
        $client = new Client;
        $method = 'POST';
        $uri = $this->getConfig('api');
        $token = $this->getConfig('token');
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ];
        dump($content); // test
        $body = $this->getBody($content);
        $request = new Request($method, $uri, $headers, $body);
        $options = ['timeout' => 2];

        return $client->send($request, $options);
    }

    /**
     * 是否成功記錄 Log
     *
     * @param  boolean $return
     * @return boolean
     */
    public function isSuccess($return)
    {
        return ($return->getStatusCode() === Response::HTTP_CREATED);
    }

    /**
     * 取得驅動名稱
     *
     * @return string
     */
    protected function getDriverName()
    {
        return 'http';
    }

    /**
     * 取得 body
     *
     * @param  mixed $content
     * @return void
     */
    private function getBody($content)
    {
        $body = $content;
        if (is_array($content)) {
            $body = json_encode($content, JSON_UNESCAPED_UNICODE);
        }

        return $body;
    }
}