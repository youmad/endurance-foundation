<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Clock;

use Youmad\Endurance\Foundation\ValueObject\Instant;

final readonly class SystemClock implements Clock
{
    public function now(): Instant
    {
        return Instant::fromDateTimeImmutable(
            new \DateTimeImmutable(),
        );
    }
}
