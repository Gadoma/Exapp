<?php

class DateTimeFormatTransformerTest extends TestCase
{
    /**
     *  @var \Illuminate\Support\Str Laravel String helper facade
     */
    private $stringHelper;

    /**
     *  @var \Exapp\Transformers\DateTimeFormatTransformer DateTime transformer
     */
    private $dateTransformer;

    /**
     * Provide test data sets.
     *
     * @return array Test data sets
     */
    public function dataProvider()
    {
        $data = [];

        $data[] = ['26-JAN-15 10:43:27', '2015-01-26 10:43:27'];
        $data[] = ['26-Jan-15 10:43:27', '2015-01-26 10:43:27'];
        $data[] = ['04-JAN-15 10:43:27', '2015-01-04 10:43:27'];
        $data[] = ['4-JAN-15 10:43:27', '2015-01-04 10:43:27'];

        $data[] = ['46-JAN-15 10:43:27', false];
        $data[] = ['26-ABC-15 10:43:27', false];
        $data[] = ['04-JAN-AB 10:43:27', false];
        $data[] = ['04-JAN-15 40:43:27', false];
        $data[] = ['04-JAN-15 10:79:27', false];
        $data[] = ['04-JAN-15 10:43:93', false];

        return $data;
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testTransform($data, $expected)
    {
        $this->stringHelper = $this->mock('Illuminate\Support\Str');
        $this->stringHelper->shouldReceive('ascii')->once()->andReturn(str_replace('JAN', 'Jan', $data));

        \App::shouldReceive('make')->once()->with('Illuminate\Support\Str')->andReturn($this->stringHelper);

        $this->dateTransformer = new \Exapp\Transformers\DateTimeFormatTransformer();

        $actual = $this->dateTransformer->transform($data);

        $this->assertTrue($expected === $actual);
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->stringHelper);
        unset($this->dateTransformer);
    }
}
