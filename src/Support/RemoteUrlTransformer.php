<?php

namespace MarkWalet\GitState\Support;

use Illuminate\Support\Str;

class RemoteUrlTransformer
{
    /**
     * Transform the url to a visitable url.
     *
     * @param string $url
     * @return string
     */
    public static function transform(string $url): string
    {
        // Remove ssh user.
        $url = last(explode('@', $url, 2));

        // Remove http or https prefix if present.
        if (Str::startsWith($url, ['http://', 'https://'])) {
            $url = last(explode('//', $url, 2));
        }

        // Remove `.git` appendix if present.
        if (Str::endsWith($url, '.git')) {
            $url = substr($url, 0, -4);
        }

        // Replace semi colons.
        return str_replace(':', '/', $url);
    }
}
