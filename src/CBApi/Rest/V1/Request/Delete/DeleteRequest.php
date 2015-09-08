<?php

namespace CBApi\Rest\V1\Request\Delete;

use CBApi\Rest\V1\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;
use CBApi\Connection\Exception\CAInfoException;
use CBApi\Connection\Exception\CAPathException;
use CBApi\Connection\Exception\SSLVersionException;

/**
 * Class DeleteRequest
 *
 * @package CBApi\Rest\V1\Request\Delete
 */
class DeleteRequest extends RestRequest
{
    /**
     * Deletes a watchlist
     *
     * @param $id
     * @return mixed
     * @throws ConnectionErrorException
     * @throws CAInfoException
     * @throws CAPathException
     * @throws SSLVersionException
     */
    public function deleteWatchlist($id)
    {
        return $this->deleteRequest("/api/v1/watchlist/{$id}", ['id' => $id]);
    }
}
