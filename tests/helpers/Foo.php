<?php

declare(strict_types=1);

namespace FailsafePHP;

class Foo
{
    /**
     * @throws ConnectionException
     */
    public function connect(): bool
    {
        if (random_int(0, 100) % 2 === 0) {
            throw new ConnectionException('Exception!!');
        }
    }
}
