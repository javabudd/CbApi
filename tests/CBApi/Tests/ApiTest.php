<?php

namespace CBApi\Tests;

use CBApi\Api;
use CBApi\Sensors\Sensors;

/**
 * Class ApiTest
 *
 * @package CBApi\Tests
 */
class ApiTest extends \PHPUnit_Framework_TestCase
{
    /** @var Api */
    private $api;

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
        $this->api = new Api(self::$generalData['url'], self::$generalData['api_key']);
    }

    /**
     * @dataProvider connectionProvider
     * @param $apiUrl
     * @param $apiKey
     */
    public function testApi($apiUrl, $apiKey)
    {
        $api = new Api($apiUrl, $apiKey);
        self::assertNotNull($api);
    }

    /**
     * @depends testApi
     */
    public function testApiDelete()
    {
        self::assertNotNull($this->api->delete());
    }

    /**
     * @depends testApi
     */
    public function testApiGet()
    {
        self::assertNotNull($this->api->get());
    }

    /**
     * @depends testApi
     */
    public function testApiPut()
    {
        self::assertNotNull($this->api->put());
    }

    /**
     * @depends testApi
     */
    public function testApiPost()
    {
        self::assertNotNull($this->api->post());
    }

    /**
     * @throws \CBApi\Sensors\Exception\InvalidSensorException
     */
    public function testSensorFound()
    {
        self::assertTrue(is_string(Sensors::getSensor('WindowsEXE', 1)));
    }
}
