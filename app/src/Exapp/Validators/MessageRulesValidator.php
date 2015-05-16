<?php

namespace Exapp\Validators;

class MessageRulesValidator extends \Illuminate\Validation\Validator
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
        $validator = \App::make('Exapp\Transformers\DateTimeFormatTransformerInterface');

        $dateTimeFormatValid = $validator->transform($value);

        return $dateTimeFormatValid !== false ? true : false;
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
