<?php

namespace Exapp\Controllers;

class CountryController extends ApiController
{
    /**
     * @var array Allowed HTTP methods
     */
    protected $allowedMethods = ['item' => [], 'collection' => ['OPTIONS', 'GET']];

    /**
     * @var \Exapp\Repositories\CountryRepositoryInterface Country repository
     */
    protected $resourceRepo;

    /**
     * @var \Exapp\Transformers\CountryReadTransformerInterface Message write transformer
     */
    protected $readTransformer;

    /**
     * @var \Exapp\Transformers\CollectionToArrayTransformerInterface Collection to array transformer
     */
    protected $collectionTransformer;

    /**
     * Constructor.
     *
     * @param \Exapp\Repositories\CountryRepositoryInterface            $resourceRepo          Country repository
     * @param \Exapp\Transformers\CountryReadTransformerInterface       $readTransformer       Country read transformer
     * @param \Exapp\Transformers\CollectionToArrayTransformerInterface $collectionTransformer Collection to array transformer
     */
    public function __construct(\Exapp\Repositories\CountryRepositoryInterface $resourceRepo, \Exapp\Transformers\CountryReadTransformerInterface $readTransformer, \Exapp\Transformers\CollectionToArrayTransformerInterface $collectionTransformer)
    {
        parent::__construct();

        $this->resourceRepo          = $resourceRepo;
        $this->readTransformer       = $readTransformer;
        $this->collectionTransformer = $collectionTransformer;
    }

    /**
     * List items from database.
     *
     * @return \Illuminate\Http\Response The HTTP response
     */
    public function index()
    {
        try {
            $collection = $this->resourceRepo->findAll();
        } catch (\Exception $ex) {
            return $this->errorInternalError();
        }

        $data = $this->collectionTransformer->transform($collection, function ($item) {
            return $this->readTransformer->transform($item);
        });

        return $this->setStatusCode(200)->respondWithArray($data);
    }
}
