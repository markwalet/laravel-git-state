<?php

namespace MarkWalet\GitState\Exceptions;

use RuntimeException;

class MissingDriverException extends RuntimeException
{
    /**
     * NoGitRepositoryException constructor.
     *
     * @param $driver
     */
    public function __construct($driver)
    {
        $message = "Driver `{$driver}` is not supported for git-state.";

        parent::__construct($message);
    }
}
