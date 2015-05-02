<?php

namespace Exapp\Repositories;

use Exapp\Models\Message;
use Exapp\Exceptions\MassAssignmentFailedException;
use Exapp\Exceptions\RuntimeException;

class EloquentMessageRepository implements MessageRepositoryInterface
{
    /**
     * Model instance.
     *
     * @var \Exapp\Models\Message
     */
    protected $entity;

    /**
     * Constructor.
     *
     * @param \Exapp\Models\Message $entity
     */
    public function __construct(Message $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Store new instance in database.
     *
     * @param array $data
     *
     * @return \Exapp\Models\Message
     */
    public function store($data)
    {
        try {
            $entity = $this->entity->create($data);
        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\MassAssignmentException) {
                throw new MassAssignmentFailedException();
            } else {
                throw new RuntimeException($ex->getMessage());
            }
        }

        return $entity;
    }
}
