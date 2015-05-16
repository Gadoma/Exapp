<?php

class EloquentMessageRepositoryTest extends TestCase
{
    /**
     *  @var \Exapp\Repositories\EloquentMessageRepository Message repository
     */
    private $messageRepo;

    /**
     * @var \Exapp\Models\Message Message model
     */
    private $message;

    /**
     * @test
     */
    public function testStore()
    {
        $data = [
            'user_id'       => 12345,
            'currency_from' => 'EUR',
            'currency_to'   => 'GBP',
            'amount_sell'   => 1000,
            'amount_buy'    => 747.10,
            'rate'          => 0.7471,
            'time_placed'   => date('Y-m-d H:i:s'),
            'originating_country'   => 'PL',
        ];

        $this->message = $this->mock('Exapp\Models\Message');

        $this->message->shouldReceive('create')->with($data)->once()->andReturn(Mockery::self());

        $this->messageRepo = new \Exapp\Repositories\EloquentMessageRepository($this->message);

        $result = $this->messageRepo->store($data);

        $this->assertEquals($result, Mockery::self());
    }

    /**
     * Tidy up after tests.
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->message);
        unset($this->messageRepo);
    }
}
