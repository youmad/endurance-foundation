<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\ValueObject;

use Youmad\Endurance\Foundation\Exception\InvalidDuration;

final readonly class Duration
{
    private const int MICROSECONDS_PER_SECOND = 1_000_000;

    private function __construct(
        private int $microseconds,
    ) {
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public static function fromMicroseconds(int $microseconds): self
    {
        if (0 > $microseconds) {
            throw new InvalidDuration('Duration cannot be negative.');
        }

        return new self($microseconds);
    }

    public static function between(
        Instant $startedAt,
        Instant $finishedAt,
    ): self {
        if ($finishedAt->isBefore($startedAt)) {
            throw new InvalidDuration('Duration end cannot be earlier than its start.');
        }

        return new self(
            self::instantToMicroseconds($finishedAt)
            - self::instantToMicroseconds($startedAt),
        );
    }

    private static function instantToMicroseconds(
        Instant $instant,
    ): int {
        $value = $instant->toDateTimeImmutable();

        return (
            (int) $value->format('U')
            * self::MICROSECONDS_PER_SECOND
        ) + (int) $value->format('u');
    }

    public function plus(self $other): self
    {
        return new self(
            $this->microseconds + $other->microseconds,
        );
    }

    public function minus(self $other): self
    {
        $microseconds = $this->microseconds
            - $other->microseconds;

        if (0 > $microseconds) {
            throw new InvalidDuration('Duration subtraction cannot produce a negative value.');
        }

        return new self($microseconds);
    }

    public function equals(self $other): bool
    {
        return $this->microseconds === $other->microseconds;
    }

    public function isLongerThan(self $other): bool
    {
        return $this->microseconds > $other->microseconds;
    }

    public function toMicroseconds(): int
    {
        return $this->microseconds;
    }
}
