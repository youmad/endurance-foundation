<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\Clock;

use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\Clock\FrozenClock;
use Youmad\Endurance\Foundation\ValueObject\Instant;

final class FrozenClockTest extends TestCase
{
    public function testReturnsProvidedInstant(): void
    {
        $instant = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        $clock = new FrozenClock($instant);

        self::assertTrue(
            $clock->now()->equals($instant),
        );
    }

    public function testAlwaysReturnsSameInstant(): void
    {
        $instant = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        $clock = new FrozenClock($instant);

        self::assertTrue(
            $clock->now()->equals($clock->now()),
        );
    }
}
