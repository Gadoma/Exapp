<?php

namespace Exapp\Controllers;

class ApiController extends \Controller
{
    const CODE_BAD_REQUEST        = 'GEN-BAD-REQUEST';
    const CODE_INVALID_ARGUMENTS  = 'GEN-INVALID-ARGUMENTS';
    const CODE_INTERNAL_ERROR     = 'GEN-INTERNAL-ERROR';
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
     * @var array Default response headers
     */
    protected $defaultHeaders = ['Content-Type' => 'application/json; charset=utf-8'];

    /**
     * @var \Illuminate\Http\Request Current request
     */
    protected $request;

    /**
     * @var \Illuminate\Support\Facades\Response Response facade
     */
    protected $response;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->request  = \App::make('Illuminate\Http\Request');
        $this->response = \App::make('Illuminate\Support\Facades\Response');
    }

    /**
     * Get current status code.
     *
     * @return int Status code
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
     * Add the standard CORS response headers.
     *
     * @param \Illuminate\Http\Response $response The response object
     * @param string                    $options  The allowed methods indicator
     *
     * @return \Illuminate\Http\Response CORS-enabled response
     */
    protected function addCorsHeaders($response, $options)
    {
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', implode(', ', $this->allowedMethods[$options]));
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept');
        $response->header('Access-Control-Max-Age', 86400);

        return $response;
    }

    /**
     * Handle the preflight Options request.
     *
     * @param string $options The allowed methods indicator
     *
     * @return \Illuminate\Http\Response Allowed methods response
     */
    protected function respondToOptions($options)
    {
        $response = $this->response->make(null, $this->statusCode, []);

        $response->header('Allow', implode(', ', $this->allowedMethods[$options]));
        $response->header('Accept', 'application/json');
        $response->header('Accept-Charset', 'utf-8');

        return $this->addCorsHeaders($response, $options);
    }

    /**
     * Return empty response to a successful request.
     *
     * @param string $options The allowed methods indicator
     * @param array  $headers Additional response headers
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function respondNull($options = 'collection', array $headers = [])
    {
        $response = $this->response->make(null, $this->statusCode, $headers);

        return $this->addCorsHeaders($response, $options);
    }

    /**
     * Return json response with the given data.
     *
     * @param array  $array   The data to be included in the response
     * @param string $options The allowed methods indicator
     * @param array  $headers Additional response headers
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function respondWithArray(array $array, $options = 'collection', array $headers = [])
    {
        $response = $this->response->json($array, $this->statusCode, array_merge($this->defaultHeaders, $headers));

        return $this->addCorsHeaders($response, $options);
    }

    /**
     * Return error response with set status code, error code and given message.
     *
     * @param string $message   The error message to be returned
     * @param string $errorCode The error code to be returned
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function respondWithError($message, $errorCode)
    {
        return $this->respondWithArray([
                    'error' => [
                        'code'     => $errorCode,
                        'httpCode' => $this->statusCode,
                        'message'  => $message,
                    ],
        ]);
    }

    /**
     * Return response with status code 500 and given message.
     *
     * @param string $message The error message to be returned
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
     * @param string $message The error message to be returned
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
     * @param string $message The error message to be returned
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
     * @param string $message The error message to be returned
     *
     * @return \Illuminate\Http\Response Current response
     */
    protected function errorInvalidArguments($message = 'Invalid Arguments')
    {
        return $this->setStatusCode(422)->respondWithError($message, self::CODE_INVALID_ARGUMENTS);
    }
}
