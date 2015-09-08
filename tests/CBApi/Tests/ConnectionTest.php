<?php

namespace CBApi\Tests;

use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Connection\Exception\CAInfoException;
use CBApi\Rest\V1\Request\Get\GetRequest;
use CBApi\Connection\RestConnection;
use CBApi\Server\TestServer;
use Worker;
use Pool;

/**
 * Class ConnectionTest
 *
 * @package CBApi\Tests
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetRequest */
    protected $getRequest;

    /** @var Pool */
    private static $pool;

    /** @var RestConnection */
    private static $restConnection;

    public static function setUpBeforeClass()
    {
        self::$restConnection = new RestConnection('https://127.0.0.1:6969', 'asdfasdfasdf', array());
        self::$pool           = new Pool(2, Worker::class);
        self::$pool->submit(new TestServer());
    }

    public static function tearDownAfterClass()
    {
        self::$restConnection->getRequest('/stop-server');
        self::$pool->shutdown();
    }

    public function testGetRequest()
    {
        self::assertNotFalse(self::$restConnection->getRequest('/test-get-request'));
    }

    public function testPutRequest()
    {
        self::assertNotFalse(self::$restConnection->putRequest('/test-put-request', ['data' => 'test']));
    }

    public function testPostRequest()
    {
        self::assertNotFalse(self::$restConnection->postRequest('/test-post-request', ['data' => 'test']));
    }

    public function testDeleteRequest()
    {
        self::assertNotFalse(self::$restConnection->deleteRequest('/test-delete-request', ['data' => 'test']));
    }

    /**
     * @throws CAInfoException
     */
    public function testCACertNotFoundException()
    {
        self::setExpectedException(CAInfoException::class);
        $params = [
            'caInfo' => '/tmp/this_file_should_not_exist.wutang',
            'caPath' => is_dir('C:/') ? 'C:/' : '/'
        ];
        $getRequest = new GetRequest(
            new RestConnection('https://127.0.0.1:6969', 'asdfasdfas', $params)
        );

        $getRequest->info();
    }

    public function testInvalidCACertificateException()
    {
        self::setExpectedException(ConnectionErrorException::class);
        $params = [
            'caInfo' => __DIR__ . '/../files/InvalidCACert.crt',
            'caPath' => is_dir('C:/') ? 'C:/' : '/'
        ];
        $getRequest = new GetRequest(
            new RestConnection('https://127.0.0.1:6969', 'asdfasdfas', $params)
        );

        $getRequest->info();
    }
}
