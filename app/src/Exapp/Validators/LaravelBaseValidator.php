<?php

namespace Exapp\Validators;

class LaravelBaseValidator extends AbstractValidator implements LaravelValidatorInterface
{
    /**
     * Validator.
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->validator = \App::make('validator');
    }

    /**
     * Pass the data and the rules to the validator.
     *
     * @return bool Result of validation
     */
    public function passes()
    {
        $validator = $this->validator->make($this->data, static::$rules, static::$messages);

        if ($validator->fails()) {
            $this->errors = $validator->messages();

            return false;
        }

        return true;
    }
}
