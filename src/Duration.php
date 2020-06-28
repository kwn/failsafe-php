<?php

namespace FailsafePHP;

class Duration
{
    private int $miliseconds;

    private function __construct(int $miliseconds)
    {
        $this->miliseconds = $miliseconds;
    }

    public static function ofMiliseconds(int $miliseconds): self
    {
        return new self($miliseconds);
    }

    public static function ofSeconds(int $seconds): self
    {
        return new self($seconds * 1000);
    }

    public static function ofMinutes(int $minutes): self
    {
        return self::ofSeconds($minutes * 60);
    }
}
