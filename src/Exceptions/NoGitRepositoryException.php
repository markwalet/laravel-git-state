<?php

namespace MarkWalet\GitState\Exceptions;

use RuntimeException;

class NoGitRepositoryException extends RuntimeException
{
    /**
     * NoGitRepositoryException constructor.
     *
     * @param $folder
     */
    public function __construct($folder)
    {
        $message = "`{$folder}` is not a valid git repository.";

        parent::__construct($message);
    }
}
