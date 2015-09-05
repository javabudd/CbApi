<?php

namespace CBApi\Sensors;

use CBApi\Sensors\Exception\InvalidSensorException;

/**
 * Class Sensors
 *
 * @package CBApi\Sensors
 */
class Sensors
{
    /** @var array */
    private static $sensors = [
        'WindowsEXE' => '/api/v1/group/{group_id}/installer/windows/exe',
        'WindowsMSI' => '/api/v1/group/{group_id}/installer/windows/msi',
        'OSX'        => '/api/v1/group/{group_id}/installer/osx',
        'Linux'      => '/api/v1/group/{group_id}/installer/linux'
    ];

    /**
     * @return array
     */
    public static function getSensors()
    {
        return self::$sensors;
    }

    /**
     * @param $name
     * @param $groupId
     * @return mixed
     * @throws InvalidSensorException
     */
    public static function getSensor($name, $groupId)
    {
        $sensorsMapping = self::mapSensorsByGroupId($groupId);
        if (!array_key_exists($name, $sensorsMapping)) {
            throw new InvalidSensorException($name);
        }

        return $sensorsMapping[$name];
    }

    /**
     * @param $groupId
     * @return array
     */
    private static function mapSensorsByGroupId($groupId)
    {
        return array_map(
            function ($url) use ($groupId) {
                return str_replace('{group_id}', $groupId, $url);
            },
            self::$sensors
        );
    }
}
