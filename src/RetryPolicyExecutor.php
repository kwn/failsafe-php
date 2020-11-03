<?php

namespace FailsafePHP;

class RetryPolicyExecutor
{
    private RetryPolicy $retryPolicy;
    private int $failedAttempts;
    private bool $retriesExceeded;

    public function __construct(RetryPolicy $retryPolicy)
    {
        $this->retryPolicy = $retryPolicy;
        $this->failedAttempts = 0;
        $this->retriesExceeded = false;
    }

    /**
     * @throws \Throwable
     */
    public function attempt(callable $function): void
    {
        while (!$this->retriesExceeded) {
            try {
                $function();
                return;
            } catch (\Throwable $e) {
                $this->failedAttempts++;
                $this->retriesExceeded = $this->failedAttempts > $this->retryPolicy->getMaxRetries();

                if ($this->retriesExceeded || !$this->retryPolicy->handles($e)) {
                    throw $e;
                }
            }
        }
    }
}
