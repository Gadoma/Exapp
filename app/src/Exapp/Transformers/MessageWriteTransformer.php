<?php

namespace Exapp\Transformers;

class MessageWriteTransformer implements MessageWriteTransformerInterface
{
    /**
     * Helper function to process timestamp format.
     *
     * @param string Input date string
     *
     * @return string Formatted output date string
     */
    private function processDateTime($value)
    {
        $monthsCaps = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        $monthsProper = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $processedValue = \Str::ascii(strtr((string) $value, array_combine($monthsCaps, $monthsProper)));

        if ($processedValue[0] === '0') {
            $processedValue = substr($processedValue, 1);
        }

        $dateTime = \DateTime::createFromFormat('j-M-y H:i:s', $processedValue);

        return (string) $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * Transform data to write.
     *
     * @param array Data to be transformed
     *
     * @return array Transformed data
     */
    public function transform(array $data)
    {
        $result = [
        'user_id' => (string) $data['userId'],
        'currency_from' => (string) $data['currencyFrom'],
        'currency_to' => (string) $data['currencyTo'],
        'amount_sell' => (float) $data['amountSell'],
        'amount_buy' => (float) $data['amountBuy'],
        'rate' => (float) $data['rate'],
        'time_placed' => $this->processDateTime($data['timePlaced']),
        'originating_country' => (string) $data['originatingCountry'],
        ];

        return $result;
    }
}
