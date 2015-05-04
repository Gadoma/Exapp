<?php

namespace Exapp\Controllers;

class MessageController extends ApiController
{
    /**
     * @var array Allowed HTTP methods
     */
    protected $allowedMethods = ['item' => [], 'collection' => ['OPTIONS', 'POST']];

    /**
     * @var \Illuminate\Validation\Factory Validator factory
     */
    protected $validator;

    /**
     * @var \Illuminate\Config\Repository Config facade
     */
    protected $config;

    /**
     * @var \Exapp\Repositories\MessageRepositoryInterface Message repository
     */
    protected $resourceRepo;

    /**
     * @var \Exapp\Transformers\MessageWriteTransformerInterface Message write transformer
     */
    protected $writeTransformer;

    public function __construct(\Exapp\Repositories\MessageRepositoryInterface $resourceRepo, \Exapp\Transformers\MessageWriteTransformerInterface $writeTransformer)
    {
        parent::__construct();

        $this->validator = \App::make('Illuminate\Validation\Factory');
        $this->config    = \App::make('Illuminate\Config\Repository');

        $this->resourceRepo     = $resourceRepo;
        $this->writeTransformer = $writeTransformer;
    }

    /**
     * Store new message in database.
     *
     * @return \Illuminate\Http\Response The HTTP response
     */
    public function store()
    {
        $input = $this->request->json()->all();

        $rules = $this->prepareValidationRules();

        $validator = $this->validator->make($input, $rules);

        if (!$validator->passes()) {
            $errors = implode(' ', $validator->errors()->all());

            return $this->errorInvalidArguments($errors);
        }

        $data = $this->writeTransformer->transform($input);

        try {
            $this->resourceRepo->store($data);
        } catch (\Exception $ex) {
            return $this->errorInternalError($ex->getMessage());
        }

        return $this->setStatusCode(201)->respondOk();
    }

    /**
     * Prepare input validation rules.
     *
     * @return array Message validation rules
     */
    private function prepareValidationRules()
    {
        $allowedCountries  = implode(',', array_keys($this->config->get('exapp.countries')));
        $allowedCurrencies = implode(',', array_keys($this->config->get('exapp.currencies')));

        $rules = [
            'userId'             => ['required', 'digitString'],
            'currencyFrom'       => ['required', 'in:'.$allowedCurrencies],
            'currencyTo'         => ['required', 'in:'.$allowedCurrencies],
            'amountSell'         => ['required', 'positiveNumber'],
            'amountBuy'          => ['required', 'positiveNumber'],
            'rate'               => ['required', 'positiveNumber'],
            'timePlaced'         => ['required', 'dateTime'],
            'originatingCountry' => ['required', 'in:'.$allowedCountries],
        ];

        return $rules;
    }
}
