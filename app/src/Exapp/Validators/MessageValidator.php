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

        $processedValue = strtr((string) $value, array_map('ucfirst', $monthsCaps));

        if ($processedValue[0] === '0') {
            $processedValue = substr($processedValue, 1);
        }

        $dateTime = DateTime::createFromFormat('j-F-y H:i:s', $value);

        if ($dateTime === false) {
            return false;
        }

        if ($dateTime->format('j-F-y H:i:s') != $processedValue) {
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
