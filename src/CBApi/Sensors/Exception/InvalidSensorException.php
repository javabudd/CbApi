<?php

namespace CBApi\Sensors\Exception;

use CBApi\Sensors\Sensors;

/**
 * Class InvalidSensorException
 *
 * @package CBApi\Sensors\Exception
 */
class InvalidSensorException extends \Exception
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct(
            sprintf('Invalid sensor %s, should be one of %s', $name, implode(', ', array_keys(Sensors::getSensors())))
        );
    }
}
