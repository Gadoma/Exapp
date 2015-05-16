<?php

namespace Exapp\Transformers;

class DateTimeFormatTransformer implements DateTimeFormatTransformerInterface
{
    /**
     * Helper function to process timestamp format from
     * j-M-y H:i:s or d-M-y H:i:s where M is caps to Y-m-d H:i:s.
     *
     * @param string $value Input date string j-M-y H:i:s or d-M-y H:i:s where M is caps
     *
     * @return mixed Formatted output date string Y-m-d H:i:s or false on fail
     */
    public function transform($value)
    {
        $monthsCaps = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        $monthsProper = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $str = \App::make('Illuminate\Support\Str');
        $processedValue = $str::ascii(strtr((string) $value, array_combine($monthsCaps, $monthsProper)));

        if ($processedValue[0] === '0') {
            $processedValue = substr($processedValue, 1);
        }

        $dateTime = \DateTime::createFromFormat('j-M-y H:i:s', $processedValue);

        if ($dateTime === false) {
            return false;
        }

        $formatDateTime = $dateTime->format('j-M-y H:i:s');

        if ($formatDateTime !== $processedValue) {
            return false;
        }

        return (string) $dateTime->format('Y-m-d H:i:s');
    }
}
