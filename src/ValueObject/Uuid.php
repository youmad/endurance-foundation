<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\ValueObject;

use Symfony\Component\Uid\Uuid as SymfonyUuid;

final readonly class Uuid
{
    private function __construct(
        private SymfonyUuid $value,
    ) {
    }

    public static function generate(): self
    {
        return new self(SymfonyUuid::v7());
    }

    public static function fromString(string $value): self
    {
        return new self(
            SymfonyUuid::fromString($value),
        );
    }

    public function equals(self $other): bool
    {
        return $this->value->equals($other->value);
    }

    public function toString(): string
    {
        return $this->value->toRfc4122();
    }
}
