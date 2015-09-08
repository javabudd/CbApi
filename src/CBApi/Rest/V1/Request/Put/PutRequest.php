<?php

namespace CBApi\Rest\V1\Request\Put;

use CBApi\Rest\V1\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Connection\Exception\CAInfoException;
use CBApi\Connection\Exception\CAPathException;
use CBApi\Connection\Exception\SSLVersionException;

/**
 * Class PutRequest
 *
 * @package CBApi\Rest\V1\Request\Put
 */
class PutRequest extends RestRequest
{
    /**
     * @param $id
     * @param $watchlist
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function modifyWatchlist($id, $watchlist)
    {
        return $this->putRequest("/api/v1/watchlist/{$id}", [$watchlist]);
    }
}
