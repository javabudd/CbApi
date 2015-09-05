<?php

namespace CBApi\Request\Put;

use CBApi\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;

/**
 * Class PutRequest
 *
 * @package CBApi\Request\Put
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
