<?php

namespace MarkWalet\GitState\Drivers;

use MarkWalet\GitState\Exceptions\NoGitRepositoryException;
use MarkWalet\GitState\Exceptions\RuntimeException;
use Webmozart\Assert\Assert;

class ExecGitDriver implements GitDriver
{
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
        Assert::keyExists($config, 'path');

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
        $command = $this->command('rev-parse', ['--abbrev-ref', 'HEAD']);

        exec($command, $result, $code);

        if ($code !== 0 || count($result) !== 1) {
            throw new RuntimeException('Error while fetching the branch name');
        }

        return $result[0];
    }

    /**
     * Get the latest commit hash.
     *
     * @param bool $short
     * @return string
     */
    public function latestCommitHash(bool $short = false): string
    {
        $format = $short ? '%h' : '%H';
        $command = $this->command('log', ['--pretty="'.$format.'"', '-n1', 'HEAD']);

        exec($command, $result, $code);

        if ($code !== 0 || count($result) !== 1) {
            throw new RuntimeException('Error while fetching the latest commit');
        }

        return $result[0];
    }

    /**
     * Generate a git command with the given options.
     *
     * @param string $command
     * @param array $options
     * @return string
     */
    private function command(string $command, array $options = []): string
    {
        $commandOptions = $this->parseOptions($options);
        $gitOptions = $this->parseOptions([
            '--git-dir' => $this->folder,
        ]);

        return "git $gitOptions $command $commandOptions 2>/dev/null";
    }

    /**
     * Parse a list of options to an option string.
     *
     * @param array $options
     * @return string
     */
    private function parseOptions(array $options = []): string
    {
        return collect($options)->map(function ($value, $key) {
            if (is_int($key)) {
                return $value;
            }

            return "$key=$value";
        })->implode(' ');
    }
}
