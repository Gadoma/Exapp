<?php

namespace Exapp\Transformers;

use Illuminate\Database\Eloquent\Collection;

class CollectionToArrayTransformer implements CollectionToArrayTransformerInterface
{
    /**
     * Transform data from Eloquent Collection to data array using provided callback.
     *
     * @param Collection $collection Eloquent collection to be transformed
     * @param \Closure   $callback   Itme transform callback
     *
     * @return array Transformed data
     */
    public function transform(Collection $collection, \Closure $callback)
    {
        if ($collection->isEmpty()) {
            return ['data' => []];
        } elseif ($collection->count() == 1) {
            $data = $callback($collection->first()->toArray());
        } else {
            $data = [];

            foreach ($collection->toArray() as $item) {
                $data[] = $callback($item);
            }
        }

        return ['data' => $data];
    }
}
