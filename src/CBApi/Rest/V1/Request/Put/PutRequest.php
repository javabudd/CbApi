<?php

namespace CBApi\Rest\V1\Request\Put;

use CBApi\Rest\V1\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;

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
     */
    public function modifyWatchlist($id, $watchlist)
    {
        return $this->putRequest("/api/v1/watchlist/{$id}", [$watchlist]);
    }
}
