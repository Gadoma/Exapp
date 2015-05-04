<?php

namespace Exapp\Validators;

class MessageValidator extends \Illuminate\Validation\Validator
{
    /**
     * Validate that an attribute is a string consisting of digits.
     *
     * @param string $attribute  Validated attribute name
     * @param mixed  $value      Validated attribute name
     * @param mixed  $parameters Validation rule parameters
     *
     * @return bool
     */
    public function validateDigitString($attribute, $value, $parameters)
    {
        if (preg_match("/^[\d]+$/", $value)) {
            return true;
        }

        return false;
    }

    /**
     * Validate that an attribute is a valid date.
     *
     * @param string $attribute  Validated attribute name
     * @param mixed  $value      Validated attribute name
     * @param mixed  $parameters Validation rule parameters
     *
     * @return bool
     */
    public function validateDateTime($attribute, $value, $parameters)
    {
        $monthsCaps = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        $monthsProper = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $processedValue = \Str::ascii(strtr((string) $value, array_combine($monthsCaps, $monthsProper)));

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

        return true;
    }

    /**
     * Validate that an attribute is a number greater than 0.
     *
     * @param string $attribute  Validated attribute name
     * @param mixed  $value      Validated attribute name
     * @param mixed  $parameters Validation rule parameters
     *
     * @return bool
     */
    public function validatePositiveNumber($attribute, $value, $parameters)
    {
        if (preg_match("/^[0-9]*\.?[0-9]+$/", $value)) {
            return (float) $value > 0;
        }

        return false;
    }
}
