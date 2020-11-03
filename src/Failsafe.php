<?php

declare(strict_types=1);

namespace FailsafePHP;

class Failsafe
{
    private RetryPolicyExecutor $retryPolicyExecutor;

    private function __construct()
    {
    }

    public static function with(RetryPolicy $retryPolicy): self
    {
        $failsafe = new self();
        $failsafe->retryPolicyExecutor = new RetryPolicyExecutor($retryPolicy);

        return $failsafe;
    }

    /**
     * @throws \Throwable
     */
    public function run(callable $function): void
    {
        $this->retryPolicyExecutor->attempt($function);
    }

    public function get(callable $function)
    {

    }
}
