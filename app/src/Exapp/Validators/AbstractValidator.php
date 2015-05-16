<?php

namespace Exapp\Validators;

abstract class AbstractValidator
{
    /**
     * @var object Validator
     */
    protected $validator;

    /**
     * @var array Data to be validated
     */
    protected $data = array();

    /**
     * @var array Validation Rules
     */
    protected static $rules = array();

    /**
     * @var array Validation errors
     */
    protected $errors = array();

    /**
     * @var array Custom validation messages
     */
    protected static $messages = array();

    /**
     * Set data to validate.
     *
     * @param array $data
     *
     * @return self
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Return errors.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Pass the data and the rules to the validator.
     *
     * @return bool
     */
    abstract public function passes();
}
