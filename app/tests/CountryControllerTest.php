<?php

class CountryControllerTest extends TestCase
{
    /**
     * @var \Exapp\Repositories\CountryRepositoryInterface Country repository
     */
    private $resourceRepo;

    /**
     * @var \Exapp\Transformers\CollectionToArrayTransformerInterface Collection transformer
     */
    private $collectionTransformer;

    /**
     * @var \Illuminate\Database\Eloquent\Collection Eloquent collection
     */
    private $collection;

    /**
     * @test
     */
    public function testIndex()
    {
        $this->collection = $this->mock('Illuminate\Database\Eloquent\Collection');

        $this->resourceRepo = $this->mock('Exapp\Repositories\CountryRepositoryInterface');
        $this->resourceRepo->shouldReceive('findAll')->once()->andReturn($this->collection);

        $this->collectionTransformer = $this->mock('Exapp\Transformers\CollectionToArrayTransformerInterface');
        $this->collectionTransformer->shouldReceive('transform')->once()->andReturn([]);

        $this->action('GET', '\Exapp\Controllers\CountryController@index');

        $this->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function testIndexDatabaseFail()
    {
        $this->resourceRepo = $this->mock('Exapp\Repositories\CountryRepositoryInterface');
        $this->resourceRepo->shouldReceive('findAll')->once()->andThrow(new \Exception());

        $this->action('GET', '\Exapp\Controllers\CountryController@index');

        $this->assertResponseStatus(500);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->collection);
        unset($this->collectionTransformer);
        unset($this->resourceRepo);
    }
}
