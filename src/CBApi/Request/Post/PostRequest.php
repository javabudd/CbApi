<?php

namespace CBApi\Request\Post;

use CBApi\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Request\QueryException;

/**
 * Class PostRequest
 *
 * @package CBApi\Request\Post
 */
class PostRequest extends RestRequest
{
    /**
     * Apply new license to server
     *
     * @param $license
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function applyLicense($license)
    {
        return $this->postRequest('/api/v1/license', array('license' => $license));
    }

    /**
     * Sets the Bit9 Platform Server configuration
     * This includes the server address, username, and password
     * Must authenticate as a global administrator to have the rights to set this config
     * config is expected to be an array with the following keys:
     * username : username for authentication
     * password : password for authentication
     * server   : server address
     *
     * @param $config
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function setPlatformServerConfig($config)
    {
        return $this->postRequest('/api/v1/settings/global/platformserver', $config);
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
        return $this->postRequest(
            '/api/v1/process',
            $this->getBaseSearchQuery($query, $start, $rows, $sort, $facet)
        );
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
        return $this->postRequest(
            '/api/v1/binary',
            $this->getBaseSearchQuery($query, $start, $rows, $sort, $facet)
        );
    }

    /**
     * Adds a new watchlist
     *
     * Required parameters:
     * - name
     * - type
     * - searchQuery
     * - cbUrlVer
     *
     * Optional parameters:
     * - basicQueryValidation
     * - readOnly
     * - id
     *
     * @param array $params
     * @return mixed
     * @throws QueryException
     * @throws ConnectionErrorException
     */
    public function addWatchList(array $params)
    {
        $data['search_query'] = 'cb.urlver=1';
        if (array_key_exists('basicQueryValidation', $params) && false !== $params['basicQueryValidation']) {
            $this->verifyWatchlistParameters($params);
            $data = [
                'index_type'   => $params['type'],
                'name'         => $params['name'],
                'search_query' => $this->formatWatchlistSearchQuery($params['cbUrlVer'], $params['searchQuery'])
            ];
        }

        if (array_key_exists('id', $params)) {
            $data['id'] = $params['id'];
        }

        if (array_key_exists('readOnly', $params)) {
            $data['readonly'] = $params['readOnly'];
        }

        return $this->postRequest('/api/v1/watchlist', $data);
    }
}
