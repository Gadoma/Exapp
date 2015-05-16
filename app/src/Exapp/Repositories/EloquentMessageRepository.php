<?php

namespace Exapp\Repositories;

use Exapp\Models\Message;
use Exapp\Exceptions\MassAssignmentFailedException;
use Exapp\Exceptions\RuntimeException;

class EloquentMessageRepository implements MessageRepositoryInterface
{
    /**
     * @var \Exapp\Models\Message Model instance.
     */
    protected $entity;

    /**
     * Constructor.
     *
     * @param \Exapp\Models\Message $entity Message model
     */
    public function __construct(Message $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Store new instance in database.
     *
     * @param array $data Data to store
     *
     * @return \Exapp\Models\Message Stored instance
     */
    public function store($data)
    {
        try {
            $entity = $this->entity->create($data);
        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\MassAssignmentException) {
                throw new MassAssignmentFailedException($ex->getMessage());
            } else {
                throw new RuntimeException($ex->getMessage());
            }
        }

        return $entity;
    }
}
