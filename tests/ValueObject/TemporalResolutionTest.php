<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\ValueObject;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\ValueObject\Instant;
use Youmad\Endurance\Foundation\ValueObject\TemporalResolution;

final class TemporalResolutionTest extends TestCase
{
    #[DataProvider('upperBounds')]
    public function testCalculatesInclusiveUpperBound(
        TemporalResolution $resolution,
        string $value,
        string $expected,
    ): void {
        self::assertTrue(
            $resolution
                ->upperBound($this->instant($value))
                ->equals($this->instant($expected)),
        );
    }

    /**
     * @return iterable<string, array{TemporalResolution, string, string}>
     */
    public static function upperBounds(): iterable
    {
        yield 'microsecond remains exact' => [
            TemporalResolution::Microsecond,
            '2026-01-15T10:30:00.545123Z',
            '2026-01-15T10:30:00.545123Z',
        ];

        yield 'fractional second rounds upward' => [
            TemporalResolution::Second,
            '2026-01-15T10:30:00.545000Z',
            '2026-01-15T10:30:01.000000Z',
        ];

        yield 'exact second is not extended' => [
            TemporalResolution::Second,
            '2026-01-15T10:30:00.000000Z',
            '2026-01-15T10:30:00.000000Z',
        ];
    }

    public function testChecksCandidateAgainstRoundedUpperBoundary(): void
    {
        $boundary = $this->instant(
            '2026-01-15T10:30:00.545000Z',
        );

        self::assertTrue(
            TemporalResolution::Second->includesAtUpperBoundary(
                boundary: $boundary,
                candidate: $this->instant(
                    '2026-01-15T10:30:01.000000Z',
                ),
            ),
        );
        self::assertTrue(
            TemporalResolution::Second->includesAtUpperBoundary(
                boundary: $boundary,
                candidate: $this->instant(
                    '2026-01-15T10:30:01.398000Z',
                ),
            ),
        );
        self::assertFalse(
            TemporalResolution::Second->includesAtUpperBoundary(
                boundary: $boundary,
                candidate: $this->instant(
                    '2026-01-15T10:30:01.545000Z',
                ),
            ),
        );
    }

    private function instant(string $value): Instant
    {
        return Instant::fromDateTimeImmutable(
            new \DateTimeImmutable($value),
        );
    }
}
