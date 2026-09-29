<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\Clock;

use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\Clock\SystemClock;

final class SystemClockTest extends TestCase
{
    public function testNowReturnsCurrentTime(): void
    {
        $clock = new SystemClock();

        $before = new \DateTimeImmutable();
        $now = $clock->now()->toDateTimeImmutable();
        $after = new \DateTimeImmutable();

        self::assertTrue($now >= $before);
        self::assertTrue($now <= $after);
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
