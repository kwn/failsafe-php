<?php

declare(strict_types=1);

namespace FailsafePHP;

class RetryPolicy
{
    private array $handle;
    private Duration $duration;
    private int $maxRetries;

    public function handle(string ...$throwables): self
    {
        $this->handle = $throwables;

        return $this;
    }

    public function withDelay(Duration $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function withMaxReties(int $retries): self
    {
        $this->maxRetries = $retries;

        return $this;
    }

    public function handles(\Throwable $e): bool
    {
        return in_array(get_class($e), $this->handle, true);
    }
}
