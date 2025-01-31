<?php

namespace MarkWalet\GitState\Tests\Exceptions;

use MarkWalet\GitState\Exceptions\NoGitRepositoryException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class NoGitRepositoryExceptionTest extends TestCase
{
    #[Test]
    public function it_can_create_an_exception_instance(): void
    {
        $exception = new NoGitRepositoryException('example-path');

        $message = $exception->getMessage();

        $this->assertEquals('`example-path` is not a valid git repository.', $message);
    }
}
