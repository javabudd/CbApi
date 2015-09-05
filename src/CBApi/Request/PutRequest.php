<?php

namespace CBApi\Request;

use CBApi\Request\Rest\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;
use InvalidArgumentException;

/**
 * Class PutRequest
 *
 * @package CBApi\Request
 */
class PutRequest extends RestRequest
{
    /**
     * Apply new license to server
     *
     * @param $license
     * @return mixed
     * @throws ConnectionErrorException
     */
    public function license($license)
    {
        return $this->restConnection->postRequest('/api/v1/license', array('license' => $license));
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
    public function platformServerConfig($config)
    {
        return $this->restConnection->postRequest('/api/v1/settings/global/platformserver', $config);
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
     * @throws InvalidArgumentException
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

        return $this->restConnection->postRequest('/api/v1/watchlist', json_encode($data));
    }
}
