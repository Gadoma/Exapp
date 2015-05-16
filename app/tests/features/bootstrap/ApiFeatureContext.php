<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use GuzzleHttp\Client;
use Guzzle\Http\Exception\RequestException;
use PHPUnit_Framework_Assert as Assertions;

/**
 * ApiFeatureContext.
 */
class ApiFeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var \GuzzleHttp\Client Guzzle HTTP Client
     */
    protected $client;

    /**
     * @var \Guzzle\Http\Message\Request Current request object
     */
    protected $request;

    /**
     * @var \Guzzle\Http\Message\Response Current response object
     */
    protected $response;

    /**
     * @static
     * @beforeSuite
     */
    public static function setUp()
    {
        echo 'Setting up testing env';

        $unitTesting     = true;
        $testEnvironment = 'testing';

        $app = require __DIR__.'/../../../../bootstrap/start.php';
        $app->boot();

        $path = Config::get('database.connections.sqlite.database');

        if (file_exists($path)) {
            unlink($path);
        }

        touch($path);

        chmod($path, 0777);

        Artisan::call('migrate');
    }

    /**
     * @static
     * @afterSuite
     */
    public static function tearDown()
    {
        echo 'Tidying up after testing';
        $path = Config::get('database.connections.sqlite.database');
        unlink($path);
    }

    /**
     * Initialize context.
     *
     * @param array $parameters context parameters
     */
    public function __construct(array $parameters)
    {
        $config['base_url'] = $parameters['base_url'];

        $this->setClient(new Client($config));
    }

    /**
     * Get Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client Guzzle HTTP client
     */
    protected function getClient()
    {
        if (!isset($this->client)) {
            throw new \RuntimeException('Guzzle HTTP Client is not set');
        }

        return $this->client;
    }

    /**
     * Set Guzzle HTTP client.
     *
     * @param \GuzzleHttp\Client Guzzle HTTP client
     *
     * @return self
     */
    protected function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Prepare request.
     *
     * @param string $method   Requested HTTP method
     * @param string $resource Requested resource URI
     */
    protected function prepareRequest($method, $resource)
    {
        $this->request = $this->getClient()->createRequest($method, $resource);

        $this->request->addHeader('Content-Type', 'application/json');
    }

    /**
     * Send request.
     *
     * @param string $resource Requested resource URI
     */
    protected function sendRequest()
    {
        try {
            $this->response = $this->getClient()->send($this->request);
        } catch (RequestException $ex) {
            $this->response = $ex->getResponse();

            if ($this->response === null) {
                throw $ex;
            }
        }
    }

    /**
     * @Given I have test data for countries
     */
    public function iHaveTestDataForCountries()
    {
        Artisan::call('db:seed', ['--class' => 'CountriesTableSeeder']);
    }

    /**
     * @Given I have test data for messages
     */
    public function iHaveTestDataForMessages()
    {
        Artisan::call('db:seed', ['--class' => 'MessagesTableSeeder']);
    }

    /**
     * @When I call the processor command
     */
    public function iCallTheProcessorCommand()
    {
        Artisan::call('exapp:process');
    }

    /**
     * @When I request preflight options from :uri
     */
    public function iRequestPreflightOptionsFrom($uri)
    {
        $this->prepareRequest('OPTIONS', $uri);
        $this->sendRequest();
    }

    /**
     * @Then the allowed methods should be :expected
     */
    public function theAllowedMethodsShouldBe($expected)
    {
        $actual = preg_replace('/[\s:]/', '', (string) $this->response->getHeader('Allow'));
        Assertions::assertEquals($expected, $actual);
    }
}
