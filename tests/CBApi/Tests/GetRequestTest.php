<?php

namespace CBApi\Tests;

use CBApi\Request\Get\GetRequest;

/**
 * Class GetRequestTest
 *
 * @package CBApi\Tests
 */
class GetRequestTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $mb;

    public function setUp()
    {
        $this->mb = self::getMock(GetRequest::class, ['getRequest'], [], 'GetRequest', false);
        $this->mb->expects(self::once())->method('getRequest')->with(self::isType('string'));
    }

    public function testInfo()
    {
        $this->mb->info();
    }

    public function testLicenseStatus()
    {
        $this->mb->licenseStatus();
    }

    public function testPlatformServerConfig()
    {
        $this->mb->platformServerConfig();
    }

    public function testProcessSummary()
    {
        $this->mb->processSummary(1, 1, 10);
    }

    public function testProcessEvents()
    {
        $this->mb->processEvents(1, 1);
    }

    public function testProcessReport()
    {
        $this->mb->processReport(1, 1);
    }

    public function testBinarySummary()
    {
        $this->mb->binarySummary('123ASD123ASD');
    }

    public function testBinary()
    {
        $this->mb->binary('123ASD123ASD');
    }

    public function testSensors()
    {
        $this->mb->sensors(['q' => 'test']);
    }

    public function testSensorInstaller()
    {
        $this->mb->sensorInstaller('WindowsEXE', 1);
    }

    public function testSensorBacklog()
    {
        $this->mb->sensorBacklog();
    }

    public function testWatchlist()
    {
        $this->mb->watchlist(1);
    }
}
