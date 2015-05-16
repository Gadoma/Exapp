<?php

use Exapp\Models\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = '2015-05-02 12:00:00';

        $testData = [
                [
                    'country_code' => 'PL',
                    'country_name' => 'Poland',
                    'message_count' => 40,
                    'top_currency_pair' => 'PLN/CHF',
                    'top_pair_msg_cnt' => 20,
                    'top_pair_avg_rate' => 0.1234,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
                [
                    'country_code' => 'GB',
                    'country_name' => 'United Kingdom',
                    'message_count' => 20,
                    'top_currency_pair' => 'GBP/EUR',
                    'top_pair_msg_cnt' => 20,
                    'top_pair_avg_rate' => 0.1234,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
                [
                    'country_code' => 'DE',
                    'country_name' => 'Germany',
                    'message_count' => 30,
                    'top_currency_pair' => 'CHF/EUR',
                    'top_pair_msg_cnt' => 20,
                    'top_pair_avg_rate' => 0.1234,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            ];

        Country::insert($testData);
    }
}
