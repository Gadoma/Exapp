<?php

class MessageValidatorTest extends TestCase
{
    /**
     *  @var \Exapp\Validators\MessageRulesValidator Message rules validator
     */
    private $validator;

    /**
     * @var \Illuminate\Validation\Factory Laravel validator factory
     */
    private $validatorFactory;

    /**
     * @var \Illuminate\Config\Repository Laravel config repository facade
     */
    private $config;

    /**
     * @var \Exapp\Transformers\DateTimeFormatTransformerInterface DateTime transformer
     */
    private $transformer;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->config = $this->mock('Illuminate\Config\Repository');

        $this->config->shouldReceive('get')->with('exapp.countries')->andReturn(['GB' => 'United Kingdom'])
                ->shouldReceive('get')->with('exapp.currencies')->andReturn(['GBP' => 'Pound Sterling', 'EUR' => 'Euro']);

        $this->validatorFactory = \App::make('Illuminate\Validation\Factory');

        \App::shouldReceive('make')->with('validator')->once()->andReturn($this->validatorFactory)
                ->shouldReceive('make')->with('config')->once()->andReturn($this->config);

        $this->validator = new \Exapp\Validators\MessageValidator();
    }

    /**
     * Provide test data sets.
     *
     * @return array Test data sets
     */
    public function dataProvider()
    {
        $data = [];

        $data[] = [['userId' => '12345', 'currencyFrom' => 'GBP', 'currencyTo' => 'EUR', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'GB'], true];
        $data[] = [['userId' => '', 'currencyFrom' => 'GBP', 'currencyTo' => 'EUR', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'GB'], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => '', 'currencyTo' => 'EUR', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'GB'], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => 'GBP', 'currencyTo' => '', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'GB'], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => 'GBP', 'currencyTo' => 'EUR', 'amountSell' => '', 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'GB'], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => 'GBP', 'currencyTo' => 'EUR', 'amountSell' => 1000, 'amountBuy' => '', 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'GB'], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => 'GBP', 'currencyTo' => 'EUR', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => ''], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => 'GBP', 'currencyTo' => 'GBP', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'GB'], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => 'GBP', 'currencyTo' => 'GBP', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'FR'], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => 'PLN', 'currencyTo' => 'GBP', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'FR'], false];
        $data[] = [['userId' => '12345', 'currencyFrom' => 'GBP', 'currencyTo' => 'PLN', 'amountSell' => 1000, 'amountBuy' => 500, 'rate' => 0.5, 'timePlaced' => '26-JAN-15 10:23:47', 'originatingCountry' => 'FR'], false];

        return $data;
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testPasses($data, $expected)
    {
        $this->transformer = $this->mock('Exapp\Transformers\DateTimeFormatTransformerInterface');
        $this->transformer->shouldReceive('transform')->once()->with('26-JAN-15 10:23:47')->once()->andReturn('2015-01-26 10:23:47');

        \App::shouldReceive('make')->with('Exapp\Transformers\DateTimeFormatTransformerInterface')->once()->andReturn($this->transformer);

        $actual = $this->validator->with($data)->passes();

        $this->assertTrue($expected === $actual);
    }

    /**
     *  @test
     */
    public function testWithThrowsExceptionIfNotArray()
    {
        $this->setExpectedException('\Exception');

        $this->validator->with('not an array');
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->validator);
        unset($this->validatorFactory);
        unset($this->config);
        unset($this->transformer);
    }
}
