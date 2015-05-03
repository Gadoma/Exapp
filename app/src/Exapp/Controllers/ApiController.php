<?php

namespace Exapp\Controllers;

class ApiController extends \Controller
{
    const CODE_BAD_REQUEST    = 'GEN-BAD-REQUEST';
    const CODE_INVALID_ARGUMENTS     = 'GEN-INVALID-ARGUMENTS';
    const CODE_INTERNAL_ERROR = 'GEN-INTERNAL-ERROR';
    const CODE_METHOD_NOT_ALLOWED = 'GEN-METHOD-NOT-ALLOWED';

    /**
     * @var int Default response status code
     */
    protected $statusCode = 200;

    /**
     * @var array Allowed HTTP methods
     */
    protected $allowedMethods = ['item' => [], 'collection' => []];

    /**
     * @var \Illuminate\Http\Request Current request
     */
    protected $request;

    /**
     * @var \Illuminate\Support\Facades\Response Response facade
     */
    protected $response;

    public function __construct()
    {
        $this->request = \App::make('Illuminate\Http\Request');
        $this->response = \App::make('Illuminate\Support\Facades\Response');
    }

    /**
     * Get current status code.
     *
     * @return mixed Status code
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set current status code.
     *
     * @param int $statusCode Status code
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Respond to HTTP Options request.
     *
     * @return \Illuminate\Http\Response Allowed methods response
     */
    public function optionsForCollection()
    {
        return $this->respondToOptions('collection');
    }

    /**
     * Respond to a not allowed HTTP method.
     *
     * @return \Illuminate\Http\Response Allowed methods response
     */
    public function guardMethods()
    {
        return $this->errorMethodNotAllowed();
    }

    /**
     * Handle the preflight Options request.
     *
     * @param string $path The requested uri
     *
     * @return \Illuminate\Http\Response Allowed methods response
     */
    protected function respondToOptions($path)
    {
        $response = $this->response->make(null, $this->statusCode, []);

        $response->header('Allow', implode(',', $this->allowedMethods[$path]));
        $response->header('Accept', 'application/json');
        $response->header('Accept-Charset', 'utf-8');

        return $response;
    }

    /**
     * Return empty response to a successful request.
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function respondOk()
    {
        $response = $this->response->make(null, $this->statusCode, []);

        return $response;
    }

    /**
     * Return json response with the given data.
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function respondWithArray(array $array, array $headers = [])
    {
        $response = $this->response->json($array, $this->statusCode, $headers);

        $response->header('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }

    /**
     * Return error response with set status code and given message.
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function respondWithError($message, $errorCode)
    {
        return $this->respondWithArray([
                    'error' => [
                        'code'      => $errorCode,
                        'httpCode' => $this->statusCode,
                        'message'   => $message,
                    ],
        ]);
    }

    /**
     * Return response with status code 500 and given message.
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message, self::CODE_INTERNAL_ERROR);
    }

    /**
     * Return response with status code 400 and given message.
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function errorBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(400)->respondWithError($message, self::CODE_BAD_REQUEST);
    }

    /**
     * Return response with status code 400 and given message.
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        return $this->setStatusCode(405)->respondWithError($message, self::CODE_METHOD_NOT_ALLOWED);
    }

    /**
     * Return response with status code 405 and given message.
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function errorInvalidArguments($message = 'Invalid Arguments')
    {
        return $this->setStatusCode(422)->respondWithError($message, self::CODE_INVALID_ARGUMENTS);
    }
}
