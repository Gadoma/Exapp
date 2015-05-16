<?php

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        $app = require __DIR__.'/../../bootstrap/start.php';

        $app->boot();

        return $app;
    }

    /**
     * Prepare database for each test.
     */
    protected function prepareDatabase()
    {
        $path = Config::get('database.connections.sqlite.database');

        if (file_exists($path)) {
            unlink($path);
        }

        touch($path);

        Artisan::call('migrate', ['--env' => 'testing']);
    }

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Register mock object instance.
     *
     * @param string $class  Class to be mocked
     * @param array  $params Optional class constructor parameters
     *
     * @return \Mockery\Mock Mock object instance
     */
    public function mock($class, $params = [])
    {
        $mock = empty($params) ? Mockery::mock($class) : Mockery::mock($class, $params);

        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * Tidy up after each test.
     */
    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();

        $path = Config::get('database.connections.sqlite.database');

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
