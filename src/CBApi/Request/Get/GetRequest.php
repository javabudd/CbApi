<?php

namespace CBApi\Request\Get;

use CBApi\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Sensors\Exception\InvalidSensorException;

/**
 * Class GetRequest
 *
 * @package CBApi\Request\Get
 */
class GetRequest extends RestRequest
{
    /**
     * Provides high-level information about the Carbon Black Enterprise Server.
     * This function is provided for convenience and may change in future versions of the Carbon Black API.
     * Returns a json encoded array with the following fields: version(version of the Carbon Black Enterprise Server).
     *
     * @return string
     * @throws ConnectionErrorException
     */
    public function info()
    {
        return $this->getRequest('/api/info');
    }

    /**
     * Provides a summary of the current applied license
     *
     * @return string
     * @throws ConnectionErrorException
     */
    public function licenseStatus()
    {
        return $this->getRequest('/api/v1/license');
    }

    /**
     * Get Bit9 Platform Server configuration.
     * This includes server address and authentication information.
     * Must authenticate as a global administrator for this data to be available.
     * Note: the secret is never available (via query) for remote callers, although it can be applied.
     *
     * @return string
     * @throws ConnectionErrorException
     */
    public function platformServerConfig()
    {
        return $this->getRequest('/api/v1/settings/global/platformserver');
    }

    /**
     * Get the detailed metadata for a process. Requires the 'id' field from a process search result,
     * as well as a segment, also found from a process search result.
     * The results will be limited to children_count children metadata structures.
     *
     * @param     $id
     * @param     $segment
     * @param int $childrenCount
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function processSummary($id, $segment = 0, $childrenCount = 15)
    {
        return $this->getRequest(
            sprintf('/api/v1/process/%s/%s?children=%d', $id, $segment, $childrenCount)
        );
    }

    /**
     * Get all the events (filemods, regmods, etc) for a process. Requires the 'id' and 'segment_id' fields
     * from a process search result
     *
     * @param $id
     * @param $segment
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function processEvents($id, $segment = 0)
    {
        return $this->getRequest(sprintf('/api/v1/process/%s/%s/event', $id, $segment));
    }

    /**
     * Download a "report" package describing the process the format of this report is subject to change
     *
     * @param     $id
     * @param int $segment
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function processReport($id, $segment = 0)
    {
        return $this->getRequest(sprintf('/api/v1/process/%s/%s/report', $id, $segment));
    }

    /**
     * Get the metadata for a binary. Requires the md5 of the binary.
     *
     * @param $md5
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function binarySummary($md5)
    {
        return $this->getRequest(sprintf('/api/v1/binary/%s/summary', $md5));
    }

    /**
     * Download binary based on md5hash
     *
     * @param $md5hash
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function binary($md5hash)
    {
        return $this->getRequest(sprintf('/api/v1/binary/%s', $md5hash));
    }

    /**
     * Get sensors, optionally specifying search criteria
     * Arguments:
     *     ip - any portion of an ip address
     *     hostname - any portion of a hostname, case sensitive
     *     groupid - the sensor group id; must be numeric
     *
     * @param array $queryParams
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function sensors(array $queryParams)
    {
        $action = '/api/v1/sensor?';

        foreach ($queryParams as $key => $param) {
            $action .= $key . '=' . $param . '&';
        }

        return $this->getRequest($action);
    }

    /**
     * Get sensor installer package for a specified sensor group
     * Arguments:
     *     group_id - the group_id to download an installer for; defaults to 1 "Default Group"
     *     name - the sensor installer type. [WindowsEXE|WindowsMSI|OSX|Linux]
     *
     * @param     $name
     * @param int $groupId
     * @return mixed
     * @throws InvalidSensorException
     * @throws ConnectionErrorException
     */
    public function sensorInstaller($name, $groupId = 1)
    {
        return $this->getRequest($this->getSensor($name, $groupId));
    }

    /**
     * Retrieves a summary of aggregate sensor backlog across all active sensors
     *
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function sensorBacklog()
    {
        return $this->getRequest('/api/v1/sensor/statistics');
    }

    /**
     * Get all watchlists or a single watchlist
     *
     * @param null|string $id
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function watchlist($id = null)
    {
        return $this->getRequest("/api/v1/watchlist/{$id}");
    }
}
