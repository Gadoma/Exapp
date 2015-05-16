<?php

namespace Exapp\Repositories;

interface MessageRepositoryInterface
{
    /**
     * Store new instance in database.
     *
     * @param array $data Data to store
     *
     * @return \Exapp\Models\Message Stored instance
     */
    public function store($data);
}
