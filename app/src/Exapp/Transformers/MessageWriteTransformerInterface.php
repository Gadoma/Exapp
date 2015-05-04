<?php

namespace Exapp\Transformers;

interface MessageWriteTransformerInterface
{
    /**
     * Transform data to write.
     *
     * @param array Data to be transformed
     *
     * @return array Transformed data
     */
    public function transform(array $data);
}
