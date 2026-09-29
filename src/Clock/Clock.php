<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Clock;

use Youmad\Endurance\Foundation\ValueObject\Instant;

interface Clock
{
    public function now(): Instant;
}
