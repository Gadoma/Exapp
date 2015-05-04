<?php

class MessageValidatorTest extends TestCase
{
    /**
     *  @var \Exapp\Validators\MessageValidator
     */
    private $messageValidator;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->messageValidator = new \Exapp\Validators\MessageValidator($this->app['translator'], [], [], []);
    }

    /**
     * Helper function to run the actual validations.
     *
     * @param string $value The value to be validated
     *
     * @return bool The result of validation
     */
    private function runValidation($rule, $value)
    {
        $method = 'validate'.$rule;

        return $this->messageValidator->$method('attribute', $value, '');
    }

    /**
     * @test
     */
    public function testValidateDigitStringOneTwoThree()
    {
        $data = '123';

        $expected = true;
        $actual   = $this->runValidation('DigitString', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDigitStringOneTwoPointThree()
    {
        $data = '12.3';

        $expected = false;
        $actual   = $this->runValidation('DigitString', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDigitStringMinusOneTwoThree()
    {
        $data = '-123';

        $expected = false;
        $actual   = $this->runValidation('DigitString', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDigitStringAOneTwoThree()
    {
        $data = 'A123';

        $expected = false;
        $actual   = $this->runValidation('DigitString', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidatePositiveNumberZero()
    {
        $data = '0';

        $expected = false;
        $actual   = $this->runValidation('PositiveNumber', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidatePositiveNumberOneTwoThree()
    {
        $data = '123';

        $expected = true;
        $actual   = $this->runValidation('PositiveNumber', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidatePositiveNumberOneTwoPointThree()
    {
        $data = '12.3';

        $expected = true;
        $actual   = $this->runValidation('PositiveNumber', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidatePositiveNumberMinusOneTwoThree()
    {
        $data = '-123';

        $expected = false;
        $actual   = $this->runValidation('PositiveNumber', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidatePositiveNumberAOneTwoThree()
    {
        $data = 'A123';

        $expected = false;
        $actual   = $this->runValidation('PositiveNumber', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDateTimeProper()
    {
        $data = '24-JAN-15 10:27:44';

        $expected = true;
        $actual   = $this->runValidation('DateTime', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDateTimeProperLeadingZero()
    {
        $data = '04-JAN-15 10:27:44';

        $expected = true;
        $actual   = $this->runValidation('DateTime', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDateTimeProperNoLeadingZero()
    {
        $data = '4-JAN-15 10:27:44';

        $expected = true;
        $actual   = $this->runValidation('DateTime', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDateTimeWrongDay()
    {
        $data = '40-JAN-15 10:27:44';

        $expected = false;
        $actual   = $this->runValidation('DateTime', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDateTimeWrongMonth()
    {
        $data = '24-ABC-15 10:27:44';

        $expected = false;
        $actual   = $this->runValidation('DateTime', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDateTimeWrongHour()
    {
        $data = '24-JAN-15 30:27:44';

        $expected = false;
        $actual   = $this->runValidation('DateTime', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDateTimeWrongMinute()
    {
        $data = '24-JAN-15 10:70:44';

        $expected = false;
        $actual   = $this->runValidation('DateTime', $data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testValidateDateTimeWrongSecond()
    {
        $data = '24-JAN-15 10:27:70';

        $expected = false;
        $actual   = $this->runValidation('DateTime', $data);

        $this->assertEquals($expected, $actual);
    }
}
