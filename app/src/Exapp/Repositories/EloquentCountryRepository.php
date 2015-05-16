<?php

namespace Exapp\Repositories;

use Exapp\Models\Country;
use Exapp\Exceptions\RuntimeException;
use Exapp\Exceptions\MassAssignmentFailedException;

class EloquentCountryRepository implements CountryRepositoryInterface
{
    /**
     * @var \Exapp\Models\Country Model instance.
     */
    protected $entity;

    /**
     * Constructor.
     *
     * @param \Exapp\Models\Country $entity Country model
     */
    public function __construct(Country $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Get a collection of Countries from database.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of countries
     */
    public function findAll()
    {
        try {
            $collection = $this->entity->all();
        } catch (\Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }

        return $collection;
    }

    /**
     * Store new or update existing instance in database.
     *
     * @param array $attributes Selection attributes
     * @param array $data       Data to store
     *
     * @return \Exapp\Models\Country Stored instance
     */
    public function storeOrUpdate($attributes, $data)
    {
        try {
            $entity = $this->entity->updateOrCreate($attributes, $data);
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
