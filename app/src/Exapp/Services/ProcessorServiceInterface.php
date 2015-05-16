<?php

namespace Exapp\Services;

interface ProcessorServiceInterface
{
    /**
     * Process messages and generate country statistics.
     *
     * @return bool true
     */
    public function process();
}
