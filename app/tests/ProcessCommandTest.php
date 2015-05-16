<?php

class ProcessCommandTest extends TestCase
{
    /**
     *  @var \Exapp\Commands\ProcessCommand Processor command
     */
    private $procCmd;

    /**
     * @var \Exapp\Services\ProcessorServiceInterface Processor service
     */
    private $procService;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->procService = $this->mock('Exapp\Services\ProcessorServiceInterface');

        $this->procCmd = $this->mock('Exapp\Commands\ProcessCommand[info,error]', [$this->procService]);
    }

    /**
     * @test
     */
    public function testFireSuccess()
    {
        $this->procService->shouldReceive('process')->once()->andReturn(true);

        $this->procCmd->shouldReceive('info')->once();

        $result = $this->procCmd->fire();

        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function testFireError()
    {
        $this->procService->shouldReceive('process')->once()->andReturn(false);

        $this->procCmd->shouldReceive('error')->once();

        $result = $this->procCmd->fire();

        $this->assertNull($result);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->procService);
        unset($this->procCmd);
    }
}
