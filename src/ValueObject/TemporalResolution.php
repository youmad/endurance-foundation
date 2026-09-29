<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\ValueObject;

enum TemporalResolution: int
{
    private const int MICROSECONDS_PER_SECOND = 1_000_000;

    case Microsecond = 1;
    case Second = self::MICROSECONDS_PER_SECOND;

    /**
     * Returns the smallest instant representable at this resolution that is
     * greater than or equal to the supplied instant.
     */
    public function upperBound(Instant $instant): Instant
    {
        if (self::Microsecond === $this) {
            return $instant;
        }

        $value = $instant->toDateTimeImmutable();
        $microseconds = ((int) $value->format('U'))
            * self::MICROSECONDS_PER_SECOND
            + (int) $value->format('u');
        $remainder = $microseconds % $this->value;

        if (0 === $remainder) {
            return $instant;
        }

        $rounded = 0 < $microseconds
            ? $microseconds + ($this->value - $remainder)
            : $microseconds - $remainder;
        $seconds = intdiv(
            $rounded,
            self::MICROSECONDS_PER_SECOND,
        );
        $remainingMicroseconds = $rounded
            % self::MICROSECONDS_PER_SECOND;

        if (0 > $remainingMicroseconds) {
            --$seconds;
            $remainingMicroseconds += self::MICROSECONDS_PER_SECOND;
        }

        $roundedValue = new \DateTimeImmutable(
            sprintf('@%d', $seconds),
        );

        if (0 < $remainingMicroseconds) {
            $roundedValue = $roundedValue->modify(
                sprintf(
                    '+%d microseconds',
                    $remainingMicroseconds,
                ),
            );
        }

        return Instant::fromDateTimeImmutable($roundedValue);
    }

    /**
     * Allows a later boundary only when the forward drift is smaller than
     * one source-resolution step.
     */
    public function includesAtUpperBoundary(
        Instant $boundary,
        Instant $candidate,
    ): bool {
        if (!$candidate->isAfter($boundary)) {
            return true;
        }

        return Duration::between(
            $boundary,
            $candidate,
        )->toMicroseconds() < $this->value;
    }
}
