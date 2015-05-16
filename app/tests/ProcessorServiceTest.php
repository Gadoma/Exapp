<?php

class ProcessorServiceTest extends TestCase
{
    /**
     *  @var \Exapp\Services\ProcessorService Processor service
     */
    private $procService;

    /**
     * @var \Illuminate\Database\Connection Database connection
     */
    private $dbConn;

    /**
     * @var \Illuminate\Database\Manager Database connection manager
     */
    private $dbManager;

    /**
     * @var \Illuminate\Config\Repository Config repository facade
     */
    private $config;

    /**
     * @var \Exapp\Repositories\CountryRepositoryInterface Country repository
     */
    private $countryRepo;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->dbConn = $this->mock('Illuminate\Database\Connection');

        $this->dbConn->shouldReceive('raw')->once()->shouldReceive('select')->once()->andReturn([['country_code' => 'GB']]);

        $this->config = $this->mock('Illuminate\Config\Repository');

        $this->config->shouldReceive('get')->with('exapp.countries')->andReturn(['GB' => 'United Kingdom'])->shouldReceive('get')->with('database.default')->andReturn('sqlite');

        $this->dbManager = $this->mock('Illuminate\Database\Manager');

        $this->dbManager->shouldReceive('connection')->once()->andReturn($this->dbConn);

        \App::shouldReceive('make')->once()->with('db')->andReturn($this->dbManager)->shouldReceive('make')->once()->with('config')->andReturn($this->config);

        $this->countryRepo = $this->mock('Exapp\Repositories\CountryRepositoryInterface');

        $this->countryRepo->shouldReceive('storeOrUpdate')->once()->with(['country_code' => 'GB'], ['country_code' => 'GB', 'country_name' => 'United Kingdom']);

        $this->procService = new Exapp\Services\ProcessorService($this->countryRepo);
    }

    /**
     * @test
     */
    public function testProcess()
    {
        $result = $this->procService->process();

        $this->assertTrue($result);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->procService);
        unset($this->countryRepo);
        unset($this->dbManager);
        unset($this->config);
        unset($this->dbConn);
    }
}
