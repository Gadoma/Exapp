<?php

class CollectionToArrayTransformerTest extends TestCase
{
    /**
     *  @var \Exapp\Transformers\CollectionToArrayTransformer Transformer
     */
    private $transformer;

    /**
     *  @var \Closure Element tranformer callback function
     */
    private $callback;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->transformer = new \Exapp\Transformers\CollectionToArrayTransformer();

        $this->callback = function ($item) {
            return $item;
        };
    }

    /**
     * @test
     */
    public function testTransformEmpty()
    {
        $emptyCollection = $this->mock('Illuminate\Database\Eloquent\Collection');
        $emptyCollection->shouldReceive('isEmpty')->once()->andReturn(true);

        $expected = ['data' => []];

        $actual = $this->transformer->transform($emptyCollection, $this->callback);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testTransformSingle()
    {
        $singleCollection = $this->mock('Illuminate\Database\Eloquent\Collection');
        $singleCollection->shouldReceive('isEmpty')->once()->andReturn(false)
                ->shouldReceive('count')->once()->andReturn(1)
                ->shouldReceive('first')->once()->andReturn(Mockery::self())
                ->shouldReceive('toArray')->once()->andReturn([
            ['a' => 'b'],
        ]);

        $expected = ['data' => [
                ['a' => 'b'],
        ]];

        $actual = $this->transformer->transform($singleCollection, $this->callback);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function testTransformMultiple()
    {
        $multiCollection = $this->mock('Illuminate\Database\Eloquent\Collection');
        $multiCollection->shouldReceive('isEmpty')->once()->andReturn(false)
                ->shouldReceive('count')->once()->andReturn(3)
                ->shouldReceive('toArray')->once()->andReturn([
            ['a' => 'b'],
            ['c' => 'd'],
            ['e' => 'f'],
        ]);

        $expected = ['data' => [
                ['a' => 'b'],
                ['c' => 'd'],
                ['e' => 'f'],
        ]];

        $actual = $this->transformer->transform($multiCollection, $this->callback);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->transformer);
        unset($this->callback);
    }
}
