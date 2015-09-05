<?php

namespace CBApi\Rest\V1\Request\Delete;

use CBApi\Rest\V1\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;

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
     * @throws ConnectionErrorException
     */
    public function deleteWatchlist($id)
    {
        $this->deleteRequest("/api/v1/watchlist/{$id}", ['id' => $id]);
    }
}
