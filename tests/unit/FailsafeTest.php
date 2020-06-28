<?php

declare(strict_types=1);

namespace FailsafePHP;

use PHPUnit\Framework\TestCase;

class FailsafeTest extends TestCase
{
    public function testSimplePolicy(): void
    {
        $retryPolicy = (new RetryPolicy())
            ->handle(\DomainException::class, \RuntimeException::class)
            ->withDelay(Duration::ofSeconds(2))
            ->withMaxReties(3);

        $foo = new Foo();

        Failsafe::with($retryPolicy)->run(fn() => $foo->connect());
    }

    public function testSimplePolicy2(): void
    {
        $retryPolicy = (new RetryPolicy())
            ->handle(\DomainException::class)
            ->withDelay(Duration::ofSeconds(2))
            ->withMaxReties(3);

        $foo = \Mockery::spy(Foo::class);
        $foo->shouldReceive('connect')->andThrow(\DomainException::class)->byDefault();

        Failsafe::with($retryPolicy)->run(fn() => $foo->connect());

        $foo->shouldHaveReceived('connect')->times(3);
    }
}
