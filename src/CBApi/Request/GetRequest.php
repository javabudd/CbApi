<?php

namespace CBApi\Request;

use CBApi\Request\Rest\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Sensors\Exception\InvalidSensorException;

/**
 * Class GetRequest
 *
 * @package CBApi\Request
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
        return $this->restConnection->getRequest('/api/info');
    }

    /**
     * Provides a summary of the current applied license
     *
     * @return string
     * @throws ConnectionErrorException
     */
    public function licenseStatus()
    {
        return $this->restConnection->getRequest('/api/v1/license');
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
        return $this->restConnection->getRequest('/api/v1/settings/global/platformserver');
    }

    /**
     * Search for processes.
     * Arguments:
     *     query - The Cb query string; this is the same string used in the "main search box" on the process search
     *             page. "Contains text..." See Cb Query Syntax for a description of options.
     *     start - Defaulted to 0.  Will retrieve records starting at this offset.
     *     rows - Defaulted to 10. Will retrieve this many rows.
     *     sort - Default to last_update desc.  Must include a field and a sort order;
     *             results will be sorted by this param.
     *     facet_enabled - Enable facets on the result set. Defaults to enable facets (True)
     *
     * @param string    $query
     * @param int       $start
     * @param int       $rows
     * @param string    $sort
     * @param bool|true $facet
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function processSearch($query = '', $start = 0, $rows = 10, $sort = 'last_update desc', $facet = true)
    {
        return $this->restConnection->postRequest(
            '/api/v1/process',
            $this->getBaseSearch($query, $start, $rows, $sort, $facet)
        );
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
        return $this->restConnection->getRequest(
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
        return $this->restConnection->getRequest(sprintf('/api/v1/process/%s/%s/event', $id, $segment));
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
        return $this->restConnection->getRequest(sprintf('/api/v1/process/%s/%s/report', $id, $segment));
    }

    /**
     * Refer to documentation for processSearch
     *
     * @see processSearch
     *
     * @param string    $query
     * @param int       $start
     * @param int       $rows
     * @param string    $sort
     * @param bool|true $facet
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function binarySearch(
        $query = '',
        $start = 0,
        $rows = 10,
        $sort = 'server_added_timestamp desc',
        $facet = true
    ) {
        return $this->restConnection->postRequest(
            '/api/v1/binary',
            $this->getBaseSearch($query, $start, $rows, $sort, $facet)
        );
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
        return $this->restConnection->getRequest(sprintf('/api/v1/binary/%s/summary', $md5));
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
        return $this->restConnection->getRequest(sprintf('/api/v1/binary/%s', $md5hash));
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

        return $this->restConnection->getRequest($action);
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
        return $this->restConnection->getRequest($this->getSensor($name, $groupId));
    }
}
