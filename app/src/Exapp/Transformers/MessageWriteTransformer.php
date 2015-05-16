<?php

namespace Exapp\Transformers;

class MessageWriteTransformer implements MessageWriteTransformerInterface
{
    /**
     * @var \Exapp\Transformer\DateTimeFormatTransformerInterface DateTime format transformer
     */
    private $dateTransformer;

    /**
     * Constructor.
     *
     * @param \Exapp\Transformers\DateTimeFormatTransformerInterface $transformer DateTime format transformer
     */
    public function __construct(\Exapp\Transformers\DateTimeFormatTransformerInterface $transformer)
    {
        $this->dateTransformer = $transformer;
    }

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
        'user_id' => (string) $data['userId'],
        'currency_from' => (string) $data['currencyFrom'],
        'currency_to' => (string) $data['currencyTo'],
        'amount_sell' => (float) $data['amountSell'],
        'amount_buy' => (float) $data['amountBuy'],
        'rate' => (float) $data['rate'],
        'time_placed' => $this->dateTransformer->transform($data['timePlaced']),
        'originating_country' => (string) $data['originatingCountry'],
        ];

        return $result;
    }
}
