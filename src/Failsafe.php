<?php

declare(strict_types=1);

namespace FailsafePHP;

class Failsafe
{
    private RetryPolicy $retryPolicy;

    private function __construct()
    {
    }

    public static function with(RetryPolicy $retryPolicy): self
    {
        $failsafe = new self();
        $failsafe->retryPolicy = $retryPolicy;

        return $failsafe;
    }

    public function run(callable $function): void
    {
        try {
            $function();
        } catch (\Throwable $e) {
            if ($this->retryPolicy->handles($e)) {

            }
        }
    }

    public function get(callable $function)
    {

    }
}
