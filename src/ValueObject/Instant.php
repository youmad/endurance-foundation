<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\ValueObject;

final readonly class Instant
{
    private function __construct(
        private \DateTimeImmutable $value,
    ) {
    }

    public static function fromDateTimeImmutable(\DateTimeImmutable $value): self
    {
        return new self($value);
    }

    public function toDateTimeImmutable(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value == $other->value;
    }

    public function isBefore(self $other): bool
    {
        return $this->value < $other->value;
    }

    public function isAfter(self $other): bool
    {
        return $this->value > $other->value;
    }
}
