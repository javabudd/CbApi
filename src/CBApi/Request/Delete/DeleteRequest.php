<?php

namespace CBApi\Request\Delete;

use CBApi\Request\RestRequest;
use CBApi\Connection\Exception\ConnectionErrorException;

/**
 * Class DeleteRequest
 *
 * @package CBApi\Request\Delete
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
