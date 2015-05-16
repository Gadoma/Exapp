<?php

namespace Exapp\Transformers;

class CountryReadTransformer implements CountryReadTransformerInterface
{
    /**
     * Transform data to write.
     *
     * @param array $data Data to be transformed
     *
     * @return array Transformed data
     */
    public function transform(array $data)
    {
        $result = [
           'countryCode' => (string) $data['country_code'],
           'countryName' => (string) $data['country_name'],
           'messageCount' => (int) $data['message_count'],
           'topCurrencyPair' => (string) $data['top_currency_pair'],
           'topCurrencyPairMsgCnt' => (int) $data['top_pair_msg_cnt'],
           'topCurrencyPairAvgRate' => (float) $data['top_pair_avg_rate'],
           'topCurrencyPairMsgShare' => (string) round(100 * $data['top_pair_msg_cnt'] / $data['message_count'], 2).'%',
        ];

        return $result;
    }
}
