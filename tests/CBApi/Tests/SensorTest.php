<?php

namespace CBApi\Tests;

use CBApi\Sensors\Exception\InvalidSensorException;
use CBApi\Sensors\Sensors;

/**
 * Class SensorTest
 *
 * @package CBApi\Tests
 */
class SensorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @throws InvalidSensorException
     */
    public function testSensorNotFoundException()
    {
        self::setExpectedException(InvalidSensorException::class);
        Sensors::getSensor('WindowsWOW', 1);
    }
}
