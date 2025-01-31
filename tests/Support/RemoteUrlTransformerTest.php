<?php

namespace MarkWalet\GitState\Tests\Support;

use MarkWalet\GitState\Support\RemoteUrlTransformer;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RemoteUrlTransformerTest extends TestCase
{
    #[Test]
    public function it_returns_the_url_if_it_is_already_valid(): void
    {
        $url = 'github.com/markwalet/laravel-git-state';

        $result = RemoteUrlTransformer::transform($url);

        $this->assertEquals('github.com/markwalet/laravel-git-state', $result);
    }

    #[Test]
    public function it_removes_the_http_prefix_if_present(): void
    {
        $url = 'http://github.com/markwalet/laravel-git-state';

        $result = RemoteUrlTransformer::transform($url);

        $this->assertEquals('github.com/markwalet/laravel-git-state', $result);
    }

    #[Test]
    public function it_removes_the_https_prefix_if_present(): void
    {
        $url = 'https://github.com/markwalet/laravel-git-state';

        $result = RemoteUrlTransformer::transform($url);

        $this->assertEquals('github.com/markwalet/laravel-git-state', $result);
    }

    #[Test]
    public function it_removes_the_git_appendix_if_present(): void
    {
        $url = 'https://github.com/markwalet/laravel-git-state.git';

        $result = RemoteUrlTransformer::transform($url);

        $this->assertEquals('github.com/markwalet/laravel-git-state', $result);
    }

    #[Test]
    public function it_removes_the_ssh_user_if_present(): void
    {
        $url = 'git@github.com/markwalet/laravel-git-state';

        $result = RemoteUrlTransformer::transform($url);

        $this->assertEquals('github.com/markwalet/laravel-git-state', $result);
    }

    #[Test]
    public function it_replaces_semi_colons_with_forward_slashes(): void
    {
        $url = 'github.com:markwalet/laravel-git-state';

        $result = RemoteUrlTransformer::transform($url);

        $this->assertEquals('github.com/markwalet/laravel-git-state', $result);
    }

    #[Test]
    public function it_can_format_gitlab_ssh_remotes(): void
    {
        $url = 'git@gitlab.com:gitlab-org/gitlab-foss.git';

        $result = RemoteUrlTransformer::transform($url);

        $this->assertEquals('gitlab.com/gitlab-org/gitlab-foss', $result);
    }

    #[Test]
    public function it_can_format_gitlab_http_remotes(): void
    {
        $url = 'https://gitlab.com/gitlab-org/gitlab-foss.git';

        $result = RemoteUrlTransformer::transform($url);

        $this->assertEquals('gitlab.com/gitlab-org/gitlab-foss', $result);
    }
}
