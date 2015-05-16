<?php

namespace Exapp\Transformers;

interface CountryReadTransformerInterface
{
    /**
     * Transform data to read.
     *
     * @param array $data Data to be transformed
     *
     * @return array Transformed data
     */
    public function transform(array $data);
}
