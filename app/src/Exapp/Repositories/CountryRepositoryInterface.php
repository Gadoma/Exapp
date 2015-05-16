<?php

namespace Exapp\Repositories;

interface CountryRepositoryInterface
{
    /**
     * Get all Countries from database.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of countries
     */
    public function findAll();

    /**
     * Store new or update existing instance in database.
     *
     * @param array $attributes Selection attributes
     * @param array $data       Data to store
     *
     * @return \Exapp\Models\Country Stored instance
     */
    public function storeOrUpdate($attributes, $data);
}
