<?php

namespace MarkWalet\GitState\Drivers;

use Carbon\Carbon;
use MarkWalet\GitState\Exceptions\NoGitRepositoryException;
use MarkWalet\GitState\Exceptions\RuntimeException;
use Webmozart\Assert\Assert;

class FileGitDriver implements GitDriver
{
    /** @var string */
    private string $folder;

    /**
     * GitDriverInterface constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        Assert::keyExists($config, 'path');

        $this->folder = $config['path'];
    }

    /**
     * Get the current branch.
     *
     * @return string
     */
    public function currentBranch(): string
    {
        if (is_dir($this->folder) === false) {
            throw new NoGitRepositoryException($this->folder);
        }

        $head = $this->head();
        $parts = explode('/', $head, 3);

        return $parts[2];
    }

    /**
     * Get the latest commit hash.
     *
     * @param bool $short
     * @return string
     */
    public function latestCommitHash(bool $short = false): string
    {
        if (is_dir($this->folder) === false) {
            throw new NoGitRepositoryException($this->folder);
        }

        $path = $this->path('refs'.DIRECTORY_SEPARATOR.'heads'.DIRECTORY_SEPARATOR.$this->currentBranch());

        if (file_exists($path) === false) {
            throw new RuntimeException("File `$path` is not found.");
        }

        $hash = file_get_contents($path);

        return ($short)
            ? mb_substr($hash, 0, 7)
            : trim($hash);
    }

    /**
     * Get the latest commit timestamp.
     *
     * @return Carbon
     */
    public function latestCommitTimestamp(): Carbon
    {
        preg_match('/^committer .+ (\d+) [+-]\d{4}$/m', $this->latestCommitContents(), $matches);

        if (count($matches) !== 2) {
            throw new RuntimeException('Could not extract the latest commit timestamp.');
        }

        return Carbon::createFromTimestampUTC((int) $matches[1]);
    }

    /**
     * Get the latest commit title.
     *
     * @return string
     */
    public function latestCommitTitle(): string
    {
        $lines = preg_split("/\r\n|\n|\r/", $this->latestCommitMessage());

        return $lines[0];
    }

    /**
     * Get the latest commit description.
     *
     * @return string
     */
    public function latestCommitDescription(): string
    {
        $lines = preg_split("/\r\n|\n|\r/", $this->latestCommitMessage());

        return trim(implode("\n", array_slice($lines, 1)));
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
            throw new RuntimeException($path);
        }

        return trim(file_get_contents($path));
    }

    /**
     * Read and decode the latest commit object contents.
     *
     * @return string
     */
    private function latestCommitContents(): string
    {
        $hash = $this->latestCommitHash();
        $path = $this->path('objects'.DIRECTORY_SEPARATOR.mb_substr($hash, 0, 2).DIRECTORY_SEPARATOR.mb_substr($hash, 2));

        if (file_exists($path) === false) {
            throw new RuntimeException("File `$path` is not found.");
        }

        $contents = file_get_contents($path);
        $decoded = zlib_decode($contents);

        if ($decoded === false) {
            throw new RuntimeException("Could not decode git object `$path`.");
        }

        $separator = strpos($decoded, "\0");

        if ($separator === false) {
            throw new RuntimeException("Could not parse git object `$path`.");
        }

        return substr($decoded, $separator + 1);
    }

    /**
     * Get the latest commit message.
     *
     * @return string
     */
    private function latestCommitMessage(): string
    {
        $parts = explode("\n\n", $this->latestCommitContents(), 2);

        if (count($parts) !== 2) {
            throw new RuntimeException('Could not extract the latest commit message.');
        }

        return trim($parts[1]);
    }

    /**
     * Get the absolute path based on the given file name.
     *
     * @param string $file
     * @return string
     */
    private function path(string $file): string
    {
        return $this->folder.DIRECTORY_SEPARATOR.$file;
    }
}
