<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\Clock;

use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\Clock\SystemClock;
use Youmad\Endurance\Foundation\ValueObject\Instant;

final class SystemClockTest extends TestCase
{
    public function testNowReturnsInstant(): void
    {
        $clock = new SystemClock();

        self::assertInstanceOf(
            Instant::class,
            $clock->now(),
        );
    }

    public function testTimeMovesForward(): void
    {
        $clock = new SystemClock();

        $first = $clock->now();

        usleep(1000);

        $second = $clock->now();

        self::assertTrue($second->isAfter($first));
    }
}
