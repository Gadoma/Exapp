<?php

namespace Exapp\Transformers;

interface DateTimeFormatTransformerInterface
{
    /**
     * Helper function to process timestamp format from
     * j-M-y H:i:s or d-M-y H:i:s where M is caps to Y-m-d H:i:s.
     *
     * @param string $value Input date string j-M-y H:i:s or d-M-y H:i:s where M is caps
     *
     * @return string Formatted output date string Y-m-d H:i:s
     */
    public function transform($value);
}
