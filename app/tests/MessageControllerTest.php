<?php

class MessageControllerTest extends TestCase
{
    /**
     * @var \Exapp\Validators\MessageValidatorInterface Message validator
     */
    private $validator;

    /**
     * @var \Exapp\Repositories\MessageRepositoryInterface Message repository
     */
    private $resourceRepo;

    /**
     * @var \Exapp\Transformers\MessageWriteTransformerInterface Message write transformer
     */
    private $writeTransformer;

    /**
     * @test
     */
    public function testStoreOk()
    {
        $this->validator = $this->mock('Exapp\Validators\MessageValidatorInterface');
        $this->validator->shouldReceive('with')->once()->with([])->andReturn(Mockery::self())->shouldReceive('passes')->once()->andReturn(true);

        $this->writeTransformer = $this->mock('Exapp\Transformers\MessageWriteTransformerInterface');
        $this->writeTransformer->shouldReceive('transform')->once()->with([])->andReturn([]);

        $this->resourceRepo = $this->mock('Exapp\Repositories\MessageRepositoryInterface');
        $this->resourceRepo->shouldReceive('store')->once()->with([]);

        $this->action('POST', '\Exapp\Controllers\MessageController@store');

        $this->assertResponseStatus(201);
    }

    /**
     * @test
     */
    public function testStoreValidationFail()
    {
        $this->validator = $this->mock('Exapp\Validators\MessageValidatorInterface');
        $this->validator->shouldReceive('with')->once()->with([])->andReturn(Mockery::self())
                        ->shouldReceive('passes')->once()->andReturn(false)
                        ->shouldReceive('errors')->once()->andReturn(Mockery::self())
                        ->shouldReceive('all')->once()->andReturn([]);

        $this->action('POST', '\Exapp\Controllers\MessageController@store');

        $this->assertResponseStatus(422);
    }

    /**
     * @test
     */
    public function testStoreDatabaseFail()
    {
        $this->validator = $this->mock('Exapp\Validators\MessageValidatorInterface');
        $this->validator->shouldReceive('with')->once()->with([])->andReturn(Mockery::self())->shouldReceive('passes')->once()->andReturn(true);

        $this->writeTransformer = $this->mock('Exapp\Transformers\MessageWriteTransformerInterface');
        $this->writeTransformer->shouldReceive('transform')->once()->with([])->andReturn([]);

        $this->resourceRepo = $this->mock('Exapp\Repositories\MessageRepositoryInterface');
        $this->resourceRepo->shouldReceive('store')->once()->with([])->andThrow(new \Exception());

        $this->action('POST', '\Exapp\Controllers\MessageController@store');

        $this->assertResponseStatus(500);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->validator);
        unset($this->writeTransformer);
        unset($this->resourceRepo);
    }
}
