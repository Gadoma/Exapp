<?php

class EloquentMessageRepositoryTest extends TestCase
{
    /**
     *  @var \Exapp\Repositories\EloquentMessageRepository
     */
    private $messageRepo;

    /**
     * @var \Exapp\Models\Message
     */
    private $message;

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->message = $this->mock('Exapp\Models\Message');

        $this->messageRepo = new \Exapp\Repositories\EloquentMessageRepository($this->message);
    }

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
        ];

        $this->message->shouldReceive('create')->once()->andReturn(Mockery::self());

        $this->messageRepo->store($data);
    }
}
