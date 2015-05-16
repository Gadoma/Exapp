<?php

namespace Exapp\Commands;

use Illuminate\Console\Command;

class ProcessCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'exapp:process';

    /**
     * @var string The console command description.
     */
    protected $description = 'Process messages and generate country statistics.';

    /*
     *
     * @var \Exapp\Services\ProcessorServiceInterface The processor service
     */
    protected $procService;

    /**
     * Create a new command instance.
     */
    public function __construct(\Exapp\Services\ProcessorServiceInterface $procService)
    {
        parent::__construct();

        $this->procService = $procService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed Command result
     */
    public function fire()
    {
        try {
            $result = $this->procService->process();
        } catch (\Exception $ex) {
            return $this->error($ex->getMessage());
        }

        if ($result) {
            return $this->info('Messages processed, Country statistics created.');
        } else {
            return $this->error('Something went wrong, Country statistics not created.');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array Array of command arguments
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array Array of command options
     */
    protected function getOptions()
    {
        return [];
    }
}
