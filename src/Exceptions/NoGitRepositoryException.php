<?php

namespace MarkWalet\GitState\Exceptions;

use RuntimeException;

class NoGitRepositoryException extends RuntimeException
{
    /**
     * NoGitRepositoryException constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $message = "`$path` is not a valid git repository.";

        parent::__construct($message);
    }
}
