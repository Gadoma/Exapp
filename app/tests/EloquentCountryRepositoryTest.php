<?php

class EloquentCountryRepositoryTest extends TestCase
{
    /**
     *  @var \Exapp\Repositories\EloquentCountryRepository Country repository
     */
    private $countryRepo;

    /**
     * @var \Exapp\Models\Country Country model
     */
    private $country;

    /**
     * @test
     */
    public function testFindAll()
    {
        $this->country = $this->mock('Exapp\Models\Country');
        $this->country->shouldReceive('all')->once()->andReturn(Mockery::self());

        $this->countryRepo = new \Exapp\Repositories\EloquentCountryRepository($this->country);

        $result = $this->countryRepo->findAll();

        $this->assertEquals($result, Mockery::self());
    }

    /**
     * @test
     */
    public function testStoreOrUpdate()
    {
        $attributes = [
        ];

        $data = [
            'country_code'      => 'PL',
            'country_name'      => 'Poland',
            'message_count'     => '10',
            'top_currency_pair' => 'EUR/GBP',
            'top_pair_msg_cnt'  => 10,
            'top_pair_avg_rate' => 0.7471,
        ];

        $this->country = $this->mock('Exapp\Models\Country');
        $this->country->shouldReceive('updateOrCreate')->with($attributes, $data)->once()->andReturn(Mockery::self());

        $this->countryRepo = new \Exapp\Repositories\EloquentCountryRepository($this->country);

        $result = $this->countryRepo->storeOrUpdate($attributes, $data);

        $this->assertEquals($result, Mockery::self());
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->country);
        unset($this->countryRepo);
    }
}
