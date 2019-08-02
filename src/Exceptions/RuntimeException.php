<?php

namespace MarkWalet\GitState\Exceptions;

use RuntimeException as BaseRuntimeException;

class RuntimeException extends BaseRuntimeException
{
    /**
     * NoGitRepositoryException constructor.
     *
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
