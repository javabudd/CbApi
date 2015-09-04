<?php

namespace CBApi\Sensors;

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
     * @param $groupId
     * @return array
     */
    public static function getSensorMapping($groupId)
    {
        return array_map(
            function ($url) use ($groupId) {
                return str_replace('{group_id}', $groupId, $url);
            },
            self::getSensors()
        );
    }
}
