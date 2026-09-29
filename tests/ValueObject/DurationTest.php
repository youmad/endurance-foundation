<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\Exception\InvalidDuration;
use Youmad\Endurance\Foundation\ValueObject\Duration;
use Youmad\Endurance\Foundation\ValueObject\Instant;

final class DurationTest extends TestCase
{
    public function testCanCreateZeroDuration(): void
    {
        $duration = Duration::zero();

        self::assertSame(
            0,
            $duration->toMicroseconds(),
        );
    }

    public function testCanCreateDurationFromMicroseconds(): void
    {
        $duration = Duration::fromMicroseconds(
            1_500_001,
        );

        self::assertSame(
            1_500_001,
            $duration->toMicroseconds(),
        );
    }

    public function testCannotCreateNegativeDuration(): void
    {
        $this->expectException(
            InvalidDuration::class,
        );

        Duration::fromMicroseconds(-1);
    }

    public function testCanCalculateDurationBetweenInstants(): void
    {
        $startedAt = $this->instant(
            '2026-01-15T10:30:45.123456Z',
        );

        $finishedAt = $this->instant(
            '2026-01-15T10:30:46.623457Z',
        );

        $duration = Duration::between(
            $startedAt,
            $finishedAt,
        );

        self::assertSame(
            1_500_001,
            $duration->toMicroseconds(),
        );
    }

    private function instant(string $value): Instant
    {
        return Instant::fromDateTimeImmutable(
            new \DateTimeImmutable($value),
        );
    }

    public function testDurationBetweenEqualInstantsIsZero(): void
    {
        $instant = $this->instant(
            '2026-01-15T10:30:45.123456Z',
        );

        $duration = Duration::between(
            $instant,
            $instant,
        );

        self::assertTrue(
            $duration->equals(
                Duration::zero(),
            ),
        );
    }

    public function testCannotCalculateDurationWhenEndIsBeforeStart(): void
    {
        $startedAt = $this->instant(
            '2026-01-15T10:30:46Z',
        );

        $finishedAt = $this->instant(
            '2026-01-15T10:30:45Z',
        );

        $this->expectException(
            InvalidDuration::class,
        );

        Duration::between(
            $startedAt,
            $finishedAt,
        );
    }

    public function testCanAddDurations(): void
    {
        $first = Duration::fromMicroseconds(
            1_500_000,
        );

        $second = Duration::fromMicroseconds(
            2_750_000,
        );

        $result = $first->plus($second);

        self::assertSame(
            4_250_000,
            $result->toMicroseconds(),
        );
    }

    public function testCanSubtractDurations(): void
    {
        $first = Duration::fromMicroseconds(
            4_250_000,
        );

        $second = Duration::fromMicroseconds(
            1_500_000,
        );

        $result = $first->minus($second);

        self::assertSame(
            2_750_000,
            $result->toMicroseconds(),
        );
    }

    public function testCanSubtractEqualDurations(): void
    {
        $first = Duration::fromMicroseconds(
            1_500_000,
        );

        $second = Duration::fromMicroseconds(
            1_500_000,
        );

        $result = $first->minus($second);

        self::assertTrue(
            $result->equals(
                Duration::zero(),
            ),
        );
    }

    public function testCannotSubtractLargerDuration(): void
    {
        $first = Duration::fromMicroseconds(
            1_500_000,
        );

        $second = Duration::fromMicroseconds(
            1_500_001,
        );

        $this->expectException(
            InvalidDuration::class,
        );

        $first->minus($second);
    }

    public function testCanCompareEqualDurations(): void
    {
        $first = Duration::fromMicroseconds(
            1_500_000,
        );

        $second = Duration::fromMicroseconds(
            1_500_000,
        );

        self::assertTrue(
            $first->equals($second),
        );
    }

    public function testCanCompareDifferentDurations(): void
    {
        $first = Duration::fromMicroseconds(
            1_500_000,
        );

        $second = Duration::fromMicroseconds(
            1_500_001,
        );

        self::assertFalse(
            $first->equals($second),
        );
    }

    public function testCanDetermineThatDurationIsLonger(): void
    {
        $duration = Duration::fromMicroseconds(
            1_500_001,
        );

        $other = Duration::fromMicroseconds(
            1_500_000,
        );

        self::assertTrue(
            $duration->isLongerThan($other),
        );
    }

    public function testEqualDurationIsNotLonger(): void
    {
        $duration = Duration::fromMicroseconds(
            1_500_000,
        );

        $other = Duration::fromMicroseconds(
            1_500_000,
        );

        self::assertFalse(
            $duration->isLongerThan($other),
        );
    }

    public function testCanDetermineThatDurationIsNotLonger(): void
    {
        $duration = Duration::fromMicroseconds(
            1_499_999,
        );

        $other = Duration::fromMicroseconds(
            1_500_000,
        );

        self::assertFalse(
            $duration->isLongerThan($other),
        );
    }
}
