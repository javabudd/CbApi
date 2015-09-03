<?php

namespace CBApi\Tests;

use CBApi\Connection\Request;
use CBApi\Rest\Get;
use CBApi\Rest\Put;

/**
 * Class ApiTest
 *
 * @package CBApi\Tests
 */
class ApiTest extends \PHPUnit_Framework_TestCase
{
    /** @var \CBApi\Rest\Get */
    private $get;

    /** @var \CBApi\Rest\Put */
    private $put;

    /** @var \CBApi\Connection\Request */
    private $request;

    /** @var array */
    private static $generalData = [
        'url'         => 'http://localhosterino',
        'ssl_url'     => 'https://localhosterino',
        'api_key'     => '12345-12345-12354-12345',
        'api_key_int' => 12345-12345-12345-12345,
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
        $this->request = new Request(self::$generalData['url'], self::$generalData['api_key']);
    }

    /**
     * @dataProvider connectionProvider
     * @param $api_key
     * @param $url
     */
    public function testRequestObj($url, $api_key)
    {
        self::assertNotNull($this->createRequestObj($url, $api_key));
    }

    /**
     * @depends testRequestObj
     */
    public function testGetNotNull()
    {
        self::assertNotNull($this->getGetObj());
    }

    /**
     * @depends testRequestObj
     */
    public function testPutNotNull()
    {
        self::assertNotNull($this->getPutObj());
    }

    /**
     * @depends testGetNotNull
     */
    public function testBadGetConnection()
    {
        self::assertEquals(false, $this->getGetObj()->info());
    }

    /**
     * @depends testPutNotNull
     */
    public function testBadPutConnection()
    {
        self::assertEquals(false, $this->getPutObj()->license(self::$generalData['license']));
    }

    /**
     * @return \CBApi\Rest\Get
     */
    private function getGetObj()
    {
        if (!$this->get) {
            $this->get = new Get($this->request);
        }

        return $this->get;
    }

    /**
     * @return \CBApi\Rest\Put
     */
    private function getPutObj()
    {
        if (!$this->put) {
            $this->put = new Put($this->request);
        }

        return $this->put;
    }

    /**
     * @param $url
     * @param $api_key
     * @return \CBApi\Connection\Request
     */
    private function createRequestObj($url, $api_key)
    {
        return new Request($url, $api_key);
    }
}
