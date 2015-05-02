<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    protected $app;

    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
    }

    /**
     * Prepare for each test.
     */
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    /**
     * Register mock object instance.
     *
     * @param string $class Class to be mocked
     *
     * @return \Mockery\Mock Mock object instance
     */
    public function mock($class)
    {
        $mock = Mockery::mock($class);

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
    }
}
