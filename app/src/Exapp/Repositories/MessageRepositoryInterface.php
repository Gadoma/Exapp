<?php

namespace Exapp\Repositories;

interface MessageRepositoryInterface
{
    /**
     * Store new instance in database.
     *
     * @param array $data
     *
     * @return \Exapp\Models\Message
     */
    public function store($data);
}
