<?php

namespace MarkWalet\GitState\Exceptions;

use RuntimeException;

class FileNotFoundException extends RuntimeException
{
    /**
     * FileNotFoundException constructor.
     *
     * @param $path
     */
    public function __construct($path)
    {
        $message = "File `$path` is not found.";

        parent::__construct($message);
    }
}
