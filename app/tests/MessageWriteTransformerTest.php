<?php

class MessageWriteTransformerTest extends TestCase
{
    /**
     *  @var \Exapp\Transformers\MessageWriteTransformer Message transformer
     */
    private $messageTransformer;

    /**
     *  @var \Exapp\Transformers\DateTimeFormatTransformerInterface DateTime transformer
     */
    private $dateTransformer;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->dateTransformer = $this->mock('Exapp\Transformers\DateTimeFormatTransformerInterface');

        $this->dateTransformer->shouldReceive('transform')->with('26-JAN-15 10:46:27')->once()->andReturn('2015-01-26 10:46:27');

        $this->messageTransformer = new \Exapp\Transformers\MessageWriteTransformer($this->dateTransformer);
    }

    /**
     * @test
     */
    public function testTransform()
    {
        $data = [
            'userId'             => '12345',
            'currencyFrom'       => 'EUR',
            'currencyTo'         => 'GBP',
            'amountSell'         => 1000,
            'amountBuy'          => 700,
            'rate'                => 0.7,
            'timePlaced'         => '26-JAN-15 10:46:27',
            'originatingCountry' => 'GB',
        ];

        $expected = [
            'user_id'             => '12345',
            'currency_from'       => 'EUR',
            'currency_to'         => 'GBP',
            'amount_sell'         => 1000,
            'amount_buy'          => 700,
            'rate'                => 0.7,
            'time_placed'         => '2015-01-26 10:46:27',
            'originating_country' => 'GB',
        ];

        $actual = $this->messageTransformer->transform($data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->messageTransformer);
        unset($this->dateTransformer);
    }
}
