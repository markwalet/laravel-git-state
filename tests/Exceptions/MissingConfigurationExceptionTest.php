<?php

namespace MarkWalet\GitState\Tests\Exceptions;

use MarkWalet\GitState\Exceptions\MissingConfigurationException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MissingConfigurationExceptionTest extends TestCase
{
    #[Test]
    public function it_can_create_an_exception_instance(): void
    {
        $exception = new MissingConfigurationException('config');

        $message = $exception->getMessage();

        $this->assertEquals('Configuration key `config` is missing.', $message);
    }
}
