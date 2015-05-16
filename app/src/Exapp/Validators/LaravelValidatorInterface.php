<?php

namespace Exapp\Validators;

interface LaravelValidatorInterface
{
  /**
   * Pass input for validation.
   *
   * @param array
   *
   * @return self
   */
  public function with(array $input);

  /**
   * Data passes validation.
   *
   * @return bool Result of validation
   */
  public function passes();

  /**
   * Validation errors.
   *
   * @return array Array of errors
   */
  public function errors();
}
