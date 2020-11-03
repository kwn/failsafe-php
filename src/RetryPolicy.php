<?php

declare(strict_types=1);

namespace FailsafePHP;

class RetryPolicy
{
    private array $throwables;
    private Duration $delay;
    private int $maxRetries;

    public function handle(string ...$throwables): self
    {
        $this->throwables = $throwables;

        return $this;
    }

    public function handles(\Throwable $e): bool
    {
        return in_array(get_class($e), $this->throwables, true);
    }

    public function withDelay(Duration $duration): self
    {
        $this->delay = $duration;

        return $this;
    }

    public function withMaxReties(int $retries): self
    {
        $this->maxRetries = $retries;

        return $this;
    }

    public function getThrowables(): array
    {
        return $this->throwables;
    }

    public function getMaxRetries(): int
    {
        return $this->maxRetries;
    }

    public function getDelay(): Duration
    {
        return $this->delay;
    }
}
