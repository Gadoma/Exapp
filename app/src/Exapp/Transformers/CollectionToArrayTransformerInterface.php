<?php

namespace Exapp\Transformers;

use Illuminate\Database\Eloquent\Collection;

interface CollectionToArrayTransformerInterface
{
    /**
     * Transform data from Eloquent Collection to data array using provided callback.
     *
     * @param Collection $collection Eloquent collection to be transformed
     * @param \Closure   $callback   Itme transform callback
     *
     * @return array Transformed data
     */
    public function transform(Collection $collection, \Closure $callback);
}
