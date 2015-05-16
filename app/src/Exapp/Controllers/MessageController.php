<?php

namespace Exapp\Controllers;

class MessageController extends ApiController
{
    /**
     * @var array Allowed HTTP methods
     */
    protected $allowedMethods = ['item' => [], 'collection' => ['OPTIONS', 'POST']];

    /**
     * @var \Exapp\Validators\MessageValidatorInterface Message validator
     */
    protected $validator;

    /**
     * @var \Exapp\Repositories\MessageRepositoryInterface Message repository
     */
    protected $resourceRepo;

    /**
     * @var \Exapp\Transformers\MessageWriteTransformerInterface Message write transformer
     */
    protected $writeTransformer;

    /**
     * Constructor.
     *
     * @param \Exapp\Repositories\MessageRepositoryInterface       $resourceRepo     Message repository
     * @param \Exapp\Transformers\MessageWriteTransformerInterface $writeTransformer Message write transformer
     * @param \Exapp\Validators\MessageValidatorInterface          $validator        Message validator
     */
    public function __construct(\Exapp\Repositories\MessageRepositoryInterface $resourceRepo, \Exapp\Transformers\MessageWriteTransformerInterface $writeTransformer, \Exapp\Validators\MessageValidatorInterface $validator)
    {
        parent::__construct();

        $this->validator = $validator;
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

        $validator = $this->validator->with($input);

        if (!$validator->passes()) {
            $errors = implode(' ', $validator->errors()->all());

            return $this->errorInvalidArguments($errors);
        }

        $data = $this->writeTransformer->transform($input);

        try {
            $this->resourceRepo->store($data);
        } catch (\Exception $ex) {
            return $this->errorInternalError();
        }

        return $this->setStatusCode(201)->respondNull();
    }
}
