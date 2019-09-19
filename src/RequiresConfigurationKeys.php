<?php

namespace MarkWalet\GitState;

use Illuminate\Support\Arr;
use MarkWalet\GitState\Exceptions\InvalidArgumentException;

trait RequiresConfigurationKeys
{
    /**
     * Make sure certain items are present in the configuration array.
     *
     * @param array $config
     * @param array|string $required
     * @throws InvalidArgumentException
     */
    protected function require(array $config, $required)
    {
        $required = Arr::wrap($required);

        foreach ($required as $r) {
            if (isset($config[$r]) === false) {
                throw new InvalidArgumentException("Missing `{$r}`-key in configuration");
            }
        }
    }
}
