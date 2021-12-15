<?php

namespace MarkWalet\GitState\Exceptions;

use RuntimeException;

class MissingDriverException extends RuntimeException
{
    /**
     * MissingDriverException constructor.
     *
     * @param string $driver
     */
    public function __construct(string $driver)
    {
        $message = "Driver `$driver` is not supported for git-state.";

        parent::__construct($message);
    }
}
