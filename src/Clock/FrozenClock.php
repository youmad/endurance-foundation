<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Clock;

use Youmad\Endurance\Foundation\ValueObject\Instant;

final readonly class FrozenClock implements Clock
{
    public function __construct(
        private Instant $instant,
    ) {
    }

    public function now(): Instant
    {
        return $this->instant;
    }
}
