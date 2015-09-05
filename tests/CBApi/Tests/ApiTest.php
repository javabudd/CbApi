<?php

namespace CBApi\Tests;

use CBApi\Connection\RestConnection;
use CBApi\Rest\V1\Request\Get\GetRequest;
use CBApi\Rest\V1\Request\Put\PutRequest;
use CBApi\Sensors\Sensors;

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
     * @throws \CBApi\Sensors\Exception\InvalidSensorException
     */
    public function testSensorFound()
    {
        self::assertTrue(is_string(Sensors::getSensor('WindowsEXE', 1)));
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
