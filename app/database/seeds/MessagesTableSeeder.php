<?php

use Exapp\Models\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = '2015-05-02 12:00:00';

        $testData = [
            [
                'user_id'       => 12345,
                'currency_from' => 'EUR',
                'currency_to'   => 'GBP',
                'amount_sell'   => 1000,
                'amount_buy'    => 700,
                'rate'          => 0.7,
                'time_placed'   => $now,
                'originating_country'   => 'GB',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id'       => 12345,
                'currency_from' => 'EUR',
                'currency_to'   => 'GBP',
                'amount_sell'   => 1000,
                'amount_buy'    => 800,
                'rate'          => 0.8,
                'time_placed'   => $now,
                'originating_country'   => 'GB',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id'       => 12345,
                'currency_from' => 'EUR',
                'currency_to'   => 'GBP',
                'amount_sell'   => 1000,
                'amount_buy'    => 900,
                'rate'          => 0.9,
                'time_placed'   => $now,
                'originating_country'   => 'GB',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Message::insert($testData);
    }
}
