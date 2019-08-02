<?php

namespace MarkWalet\GitState\Drivers;

use MarkWalet\GitState\Exceptions\FileNotFoundException;
use MarkWalet\GitState\Exceptions\NoGitRepositoryException;
use MarkWalet\GitState\RequiresConfigurationKeys;

class FileGitDriver implements GitDriver
{
    use RequiresConfigurationKeys;

    /**
     * @var string
     */
    private $folder;

    /**
     * GitDriverInterface constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->require($config, 'path');

        $this->folder = $config['path'];

        if (is_dir($this->folder) === false) {
            throw new NoGitRepositoryException($this->folder);
        }
    }

    /**
     * Get the current branch.
     *
     * @return string
     */
    public function currentBranch(): string
    {
        $head = $this->head();
        $parts = explode('/', $head, 3);

        return $parts[2];
    }

    /**
     * Get the contents of the HEAD file.
     *
     * @return string
     */
    private function head(): string
    {
        $path = $this->path('HEAD');

        if (file_exists($path) === false) {
            throw new FileNotFoundException($path);
        }

        return trim(file_get_contents($path));
    }

    /**
     * Get the absolute path based on the given file name.
     *
     * @param string $file
     * @return string
     */
    private function path(string $file)
    {
        return $this->folder.DIRECTORY_SEPARATOR.$file;
    }
}
