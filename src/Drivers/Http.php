<?php
namespace CrowsFeet\HttpLogger\Drivers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use CrowsFeet\HttpLogger\Drivers\AbstractLoggerDriver;

class Http extends AbstractLoggerDriver
{
    /**
     * 記錄 Log
     *
     * @param  mixed $content
     * @return void
     */
    public function log($content)
    {
        $client = new Client;
        $method = 'POST';
        $uri = $this->getConfig('api');
        $token = $this->getConfig('token');
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ];
        $body = $this->getBody($content);
        $request = new Request($method, $uri, $headers, $body);
        $options = ['timeout' => 2];

        return $client->send($request, $options);
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