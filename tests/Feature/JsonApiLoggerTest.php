<?php
namespace CrowsFeet\HttpLogger\Tests\Feature;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\File;
use CrowsFeet\HttpLogger\Traits\Request;
use CrowsFeet\HttpLogger\Middleware\JsonApiLogger;

class JsonApiLoggerTest extends TestCase
{
    use Request;

    /**
     * Single log path config name
     *
     * @var string
     */
    private $singleLogPathConfigName = 'logging.channels.single.path';

    /**
     * Request ID
     *
     * @var string
     */
    private $requestId;

    /**
     * Load package service provider
     *
     * @param  Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return ['CrowsFeet\HttpLogger\Providers\HttpLoggerServiceProvider'];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            $this->getLogPath(),
            storage_path('logs/json_api_logger.log')
        );
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->requestId = $this->generateRequestId();

        File::delete($this->getLogPath());
    }

    public function testJsonApiLogger()
    {
        // Execution
        $request = $this->getTestRequest();
        app(JsonApiLogger::class)->handle($request, function ($request) {
            return $this->getTestResponse();
        });

        // Assertion
        $this->assertNotEmpty($this->getTestRequestLog());
        $this->assertNotEmpty($this->getTestResponseLog());
    }

    public function testJsonApiLoggerWithRequestIdHeader()
    {
        // Execution
        $request = $this->getTestRequestWithRequestIdHeader($this->requestId);
        app(JsonApiLogger::class)->handle($request, function ($request) {
            return $this->getTestResponse();
        });

        // Assertion
        $expected = $this->requestId;
        $actual = $this->getTestRequestLogHeaderRequestId();
        $this->assertEquals($expected, $actual);
    }

    public function testJsonApiLoggerWithRequestIdBody()
    {
        // Execution
        $request = $this->getTestRequestWithRequestIdBody($this->requestId);
        app(JsonApiLogger::class)->handle($request, function ($request) {
            return $this->getTestResponse();
        });
        
        // Assertion
        $expected = $this->requestId;
        $actual = $this->getTestRequestLogBodyRequestId();
        $this->assertEquals($expected, $actual);
    }

    public function testGetHeaderRequestId()
    {
        // Execution
        $request = $this->getTestRequestWithRequestIdHeader($this->requestId);
        
        // Assertion
        $expected = $this->requestId;
        $actual = $this->getRequestId($request, $this->getRequestIdName());
        $this->assertEquals($expected, $actual);
    }

    public function testGetBodyRequestId()
    {
        // Execution
        $request = $this->getTestRequestWithRequestIdBody($this->requestId);
        
        // Assertion
        $expected = $this->requestId;
        $actual = $this->getRequestId($request, $this->getRequestIdName());
        $this->assertEquals($expected, $actual);
    }

    /**
     * Get test request
     *
     * @return \Illuminate\Http\Request|string|array
     */
    private function getTestRequest()
    {
        $request = request();
        $requestHeaderName = $this->getRequestHeaderName();
        $request->headers->set($requestHeaderName, 'Request');

        return $request;
    }

    /**
     * Get test request with request id header
     *
     * @param string $requestId
     * @return \Illuminate\Http\Request|string|array
     */
    private function getTestRequestWithRequestIdHeader($requestId)
    {
        $request = $this->getTestRequest();
        $request->headers->set($this->getRequestIdName(), $requestId);

        return $request;
    }

    /**
     * Get test request with request id body
     *
     * @param string $requestId
     * @return \Illuminate\Http\Request|string|array
     */
    private function getTestRequestWithRequestIdBody($requestId)
    {
        $request = $this->getTestRequest();
        $request->merge([$this->getRequestIdName() => $requestId]);

        return $request;
    }
    
    /**
     * Get test response
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    private function getTestResponse()
    {
        return response('Test')->header($this->getResponseHeaderName(), 'Response');
    }

    /**
     * Get log by substring
     *
     * @param array $logs
     * @param string $str
     * @return void
     */
    private function getLogBySubstring($logs, $str)
    {
        $filtered = collect($logs)->filter(function ($value, $key) use ($str) {
            return (stripos($value, $str) > 0);
        });

        return $filtered->first();
    }

    /**
     * Get test request log
     *
     * @return string
     */
    private function getTestRequestLog()
    {
        $logs = $this->getTestLogs();

        return $this->getLogBySubstring($logs, $this->getRequestHeaderName());
    }

    /**
     * Get test response log
     *
     * @return string
     */
    private function getTestResponseLog()
    {
        $logs = $this->getTestLogs();
        
        return $this->getLogBySubstring($logs, $this->getResponseHeaderName());
    }

    /**
     * Get response header name
     *
     * @return string
     */
    private function getResponseHeaderName()
    {
        return 'Test-Response-Header';
    }

    /**
     * Get request header name
     *
     * @return string
     */
    private function getRequestHeaderName()
    {
        return 'Test-Request-Header';
    }

    /**
     * Get log path
     *
     * @return string
     */
    private function getLogPath()
    {
        return config($this->singleLogPathConfigName);
    }

    /**
     * Get request Id name
     *
     * @return string
     */
    private function getRequestIdName()
    {
        return 'request-id';
    }

    /**
     * Get test request log request id in header
     *
     * @return string
     */
    private function getTestRequestLogHeaderRequestId()
    {
        $log =  $this->getTestRequestLog();
        $content = $this->getLogContent($log);
        $requestIdName = $this->getRequestIdName();

        return $content->Header->$requestIdName[0];
    }

    /**
     * Get test request log request id in body
     *
     * @return string
     */
    private function getTestRequestLogBodyRequestId()
    {
        $log =  $this->getTestRequestLog();
        $content = $this->getLogContent($log);
        $requestIdName = $this->getRequestIdName();

        return $content->Body->$requestIdName;
    }

    /**
     * Get log content
     *
     * @param string $log
     * @return object
     */
    private function getLogContent($log)
    {
        list($drop, $json) = explode(' testing.INFO: ', $log);

        return json_decode($json);
    }

    /**
     * Get test logs
     *
     * @return array
     */
    private function getTestLogs()
    {
        return file($this->getLogPath());
    }
}
