<?php

namespace MarkWalet\GitState\Tests\Exceptions;

use MarkWalet\GitState\Exceptions\MissingDriverException;
use PHPUnit\Framework\TestCase;

class MissingDriverExceptionTest extends TestCase
{
    /** @test */
    public function it_can_create_an_exception_instance(): void
    {
        $exception = new MissingDriverException('invalid-driver');

        $message = $exception->getMessage();

        $this->assertEquals('Driver `invalid-driver` is not supported for git-state.', $message);
    }
}
