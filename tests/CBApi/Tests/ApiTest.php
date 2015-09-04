<?php

namespace CBApi\Tests;

use CBApi\Connection\RestConnection;
use CBApi\Request\GetRequest;
use CBApi\Request\PutRequest;
use CBApi\Connection\Exception\ConnectionErrorException;

/**
 * Class ApiTest
 *
 * @package CBApi\Tests
 */
class ApiTest extends \PHPUnit_Framework_TestCase
{
    /** @var GetRequest */
    private $getRequest;

    /** @var PutRequest */
    private $putRequest;

    /** @var RestConnection */
    private $restConnection;

    /** @var array */
    private static $generalData = [
        'url'         => 'http://localhosterino',
        'ssl_url'     => 'https://localhosterino',
        'api_key'     => '12345-12345-12354-12345',
        'api_key_int' => 12345123451234512345,
        'license'     => '1234512345123456'
    ];

    /**
     * @return array
     */
    public static function connectionProvider()
    {
        return [
            [self::$generalData['url'], self::$generalData['api_key']],
            [self::$generalData['ssl_url'], self::$generalData['api_key_int']],
            [self::$generalData['url'], self::$generalData['api_key_int']],
            [self::$generalData['ssl_url'], self::$generalData['api_key']]
        ];
    }

    public function setUp()
    {
        $this->restConnection = new RestConnection(self::$generalData['url'], self::$generalData['api_key']);
    }

    /**
     * @dataProvider connectionProvider
     * @param $apiKey
     * @param $url
     */
    public function testRestConnection($url, $apiKey)
    {
        self::assertNotNull($this->createRestConnection($url, $apiKey));
    }

    /**
     * @depends testRestConnection
     */
    public function testGetRequestNotNull()
    {
        self::assertNotNull($this->getGetRequest());
    }

    /**
     * @depends testRestConnection
     */
    public function testPutRequestNotNull()
    {
        self::assertNotNull($this->getPutRequest());
    }

    /**
     * @depends testGetRequestNotNull
     */
    public function testBadGetConnection()
    {
        self::setExpectedException(ConnectionErrorException::class);
        self::assertEquals(false, $this->getGetRequest()->info());
    }

    /**
     * @depends testPutRequestNotNull
     */
    public function testBadPutConnection()
    {
        self::setExpectedException(ConnectionErrorException::class);
        self::assertEquals(false, $this->getPutRequest()->license(self::$generalData['license']));
    }

    /**
     * @return GetRequest
     */
    private function getGetRequest()
    {
        if (!$this->getRequest) {
            $this->getRequest = new GetRequest($this->restConnection);
        }

        return $this->getRequest;
    }

    /**
     * @return PutRequest
     */
    private function getPutRequest()
    {
        if (!$this->putRequest) {
            $this->putRequest = new PutRequest($this->restConnection);
        }

        return $this->putRequest;
    }

    /**
     * @param $url
     * @param $apiKey
     * @return \CBApi\Connection\RestConnection
     */
    private function createRestConnection($url, $apiKey)
    {
        return new RestConnection($url, $apiKey);
    }
}
