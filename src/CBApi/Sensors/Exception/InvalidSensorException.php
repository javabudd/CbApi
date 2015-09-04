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
     * @param string $type
     */
    public function __construct($type)
    {
        $sensors = implode(', ', array_keys(Sensors::getSensors()));
        parent::__construct(
            sprintf("Invalid sensor %s, should be one of {$sensors}", $type)
        );
    }
}
