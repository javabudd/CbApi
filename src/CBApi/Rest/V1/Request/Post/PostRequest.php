<?php

namespace CBApi\Rest\V1\Request\Post;

use CBApi\Rest\V1\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Connection\Exception\CAInfoException;
use CBApi\Query\Exception\QueryException;
use CBApi\Connection\Exception\CAPathException;
use CBApi\Connection\Exception\SSLVersionException;
use CBApi\Formatter\SearchQueryFormatter;
use InvalidArgumentException;
use CBApi\Formatter\WatchlistSearchQueryFormatter;
use CBApi\Validator\WatchlistParameterValidator;

/**
 * Class PostRequest
 *
 * @package CBApi\Rest\V1\Request\Post
 */
class PostRequest extends RestRequest
{
    /**
     * Apply new license to server
     *
     * @param $license
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
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
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
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
     * @throws InvalidArgumentException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function processSearch($query = '', $start = 0, $rows = 10, $sort = 'last_update desc', $facet = true)
    {
        $searchQueryFormatter = new SearchQueryFormatter();
        return $this->postRequest(
            '/api/v1/process',
            $searchQueryFormatter->format(
                [
                    'query' => $query,
                    'start' => $start,
                    'rows'  => $rows,
                    'sort'  => $sort,
                    'facet' => $facet
                ]
            )
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
     * @throws InvalidArgumentException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function binarySearch(
        $query = '',
        $start = 0,
        $rows = 10,
        $sort = 'server_added_timestamp desc',
        $facet = true
    ) {
        $searchQueryFormatter = new SearchQueryFormatter();
        return $this->postRequest(
            '/api/v1/binary',
            $searchQueryFormatter->format(
                [
                    'query' => $query,
                    'start' => $start,
                    'rows'  => $rows,
                    'sort'  => $sort,
                    'facet' => $facet
                ]
            )
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
     * @throws InvalidArgumentException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function addWatchList(array $params)
    {
        $data['search_query'] = 'cb.urlver=1';
        if (array_key_exists('basicQueryValidation', $params) && false !== $params['basicQueryValidation']) {
            $watchlistValidator = new WatchlistParameterValidator();
            $watchlistFormatter = new WatchlistSearchQueryFormatter();
            $watchlistValidator->validate($params);
            $data = [
                'index_type'   => $params['type'],
                'name'         => $params['name'],
                'search_query' => $watchlistFormatter->format(
                    [
                        'cbUrlVer'    => $params['cbUrlVer'],
                        'searchQuery' => $params['searchQuery']
                    ]
                )
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
