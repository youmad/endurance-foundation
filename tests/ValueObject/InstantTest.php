<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\ValueObject\Instant;

final class InstantTest extends TestCase
{
    public function testCanBeCreatedFromDateTimeImmutable(): void
    {
        $dateTime = new \DateTimeImmutable('2026-01-15T10:30:45Z');

        $instant = Instant::fromDateTimeImmutable($dateTime);

        self::assertEquals(
            $dateTime,
            $instant->toDateTimeImmutable(),
        );
    }

    public function testEqualsReturnsTrueForSameMoment(): void
    {
        $dateTime = new \DateTimeImmutable('2026-01-15T10:30:45Z');

        $first = Instant::fromDateTimeImmutable($dateTime);
        $second = Instant::fromDateTimeImmutable($dateTime);

        self::assertTrue($first->equals($second));
    }

    public function testEqualsReturnsFalseForDifferentMoments(): void
    {
        $first = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        $second = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:46Z'),
        );

        self::assertFalse($first->equals($second));
    }

    public function testIsBeforeReturnsTrueForEarlierInstant(): void
    {
        $earlier = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        $later = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:46Z'),
        );

        self::assertTrue($earlier->isBefore($later));
    }

    public function testIsBeforeReturnsFalseForLaterInstant(): void
    {
        $earlier = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        $later = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:46Z'),
        );

        self::assertFalse($later->isBefore($earlier));
    }

    public function testIsAfterReturnsTrueForLaterInstant(): void
    {
        $earlier = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        $later = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:46Z'),
        );

        self::assertTrue($later->isAfter($earlier));
    }

    public function testIsAfterReturnsFalseForEarlierInstant(): void
    {
        $earlier = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        $later = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:46Z'),
        );

        self::assertFalse($earlier->isAfter($later));
    }

    public function testIsBeforeReturnsFalseForSameInstant(): void
    {
        $instant = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        self::assertFalse($instant->isBefore($instant));
    }

    public function testIsAfterReturnsFalseForSameInstant(): void
    {
        $instant = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45Z'),
        );

        self::assertFalse($instant->isAfter($instant));
    }

    public function testEqualsIgnoresTimezone(): void
    {
        $utc = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T10:30:45+00:00'),
        );

        $moscow = Instant::fromDateTimeImmutable(
            new \DateTimeImmutable('2026-01-15T13:30:45+03:00'),
        );

        self::assertTrue($utc->equals($moscow));
    }
}
