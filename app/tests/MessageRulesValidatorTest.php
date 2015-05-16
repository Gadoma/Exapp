<?php

class MessageRulesValidatorTest extends TestCase
{
    /**
     *  @var \Exapp\Validators\MessageRulesValidator Message rules validator
     */
    private $messageValidator;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->messageValidator = new \Exapp\Validators\MessageRulesValidator($this->app['translator'], [], [], []);
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
     * Provide test data sets.
     *
     * @return array Test data sets
     */
    public function dataProvider()
    {
        $data = [];

        $data[] = [['DigitString', '123'], true];
        $data[] = [['DigitString', '12.3'], false];
        $data[] = [['DigitString', '-123'], false];
        $data[] = [['DigitString', 'A123'], false];

        $data[] = [['PositiveNumber', 0], false];
        $data[] = [['PositiveNumber', 123], true];
        $data[] = [['PositiveNumber', 12.3], true];
        $data[] = [['PositiveNumber', -123], false];
        $data[] = [['PositiveNumber', 'A123'], false];

        $data[] = [['DateTime', '24-JAN-15 10:27:44'], true];
        $data[] = [['DateTime', '4-JAN-15 10:27:44'], true];
        $data[] = [['DateTime', '04-JAN-15 10:27:44'], true];
        $data[] = [['DateTime', '40-JAN-15 10:27:44'], false];
        $data[] = [['DateTime', '24-ABC-15 10:27:44'], false];
        $data[] = [['DateTime', '24-JAN-15 30:27:44'], false];
        $data[] = [['DateTime', '24-JAN-15 10:70:44'], false];
        $data[] = [['DateTime', '24-JAN-15 10:27:70'], false];

        return $data;
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testValidation($data, $expected)
    {
        $actual = $this->runValidation($data[0], $data[1]);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->messageValidator);
    }
}
