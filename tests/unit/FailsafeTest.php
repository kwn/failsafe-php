<?php

declare(strict_types=1);

namespace FailsafePHP;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class FailsafeTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testAfterMaxRetriesExceptionIsThrown(): void
    {
        $this->expectException(ConnectionException::class);

        $retryPolicy = (new RetryPolicy())
            ->handle(ConnectionException::class)
            ->withMaxReties(3);

        $foo = \Mockery::spy();
        $foo->shouldReceive('connect')->andThrow(ConnectionException::class)->byDefault();

        Failsafe::with($retryPolicy)->run(fn() => $foo->connect());
    }

    public function testMaxRetries(): void
    {
        $retryPolicy = (new RetryPolicy())
            ->handle(ConnectionException::class)
            ->withMaxReties(3);

        $foo = \Mockery::spy();
        $foo->shouldReceive('connect')->andReturnUsing(function () {
            static $counter = 0;
            switch ($counter++) {
                case 0:
                case 1:
                case 2:
                    throw new ConnectionException('Error');
                default:
                    return true;
            }
        });

        Failsafe::with($retryPolicy)->run(fn() => $foo->connect());

        $foo->shouldHaveReceived('connect')->times(4);
    }
}
