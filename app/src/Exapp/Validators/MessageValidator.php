<?php

namespace Exapp\Validators;

class MessageValidator extends LaravelBaseValidator implements MessageValidatorInterface
{
    /**
     * Constructor assigning the validation rules array based on config.
     */
    public function __construct()
    {
        parent::__construct();

        $config = \App::make('config');

        $allowedCountries  = implode(',', array_keys($config->get('exapp.countries')));
        $allowedCurrencies = implode(',', array_keys($config->get('exapp.currencies')));

        $rules = [
            'userId'             => ['required', 'digitString'],
            'currencyFrom'       => ['required', 'in:'.$allowedCurrencies],
            'currencyTo'         => ['required', 'different:currencyFrom', 'in:'.$allowedCurrencies],
            'amountSell'         => ['required', 'positiveNumber'],
            'amountBuy'          => ['required', 'positiveNumber'],
            'rate'               => ['required', 'positiveNumber'],
            'timePlaced'         => ['required', 'dateTime'],
            'originatingCountry' => ['required', 'in:'.$allowedCountries],
        ];

        static::$rules = $rules;
    }
}
