<?php

class CountryReadTransformerTest extends TestCase
{
    /**
     *  @var \Exapp\Transformers\CountryReadTransformer Read transformer
     */
    private $transformer;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->transformer = new \Exapp\Transformers\CountryReadTransformer();
    }

    /**
     * @test
     */
    public function testTransform()
    {
        $data = [

            'country_code'      => 'PL',
            'country_name'      => 'Poland',
            'message_count'     => 10,
            'top_currency_pair' => 'PLN/EUR',
            'top_pair_msg_cnt'  => 1,
            'top_pair_avg_rate' => 0.5,
        ];

        $expected = [
            'countryCode'             => 'PL',
            'countryName'             => 'Poland',
            'messageCount'            => 10,
            'topCurrencyPair'         => 'PLN/EUR',
            'topCurrencyPairMsgCnt'   => 1,
            'topCurrencyPairAvgRate'  => 0.5,
            'topCurrencyPairMsgShare' => '10%',
        ];

        $actual = $this->transformer->transform($data);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->transformer);
    }
}
