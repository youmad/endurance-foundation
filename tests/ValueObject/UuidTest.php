<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\ValueObject\Uuid;

final class UuidTest extends TestCase
{
    public function testCanGenerateUuid(): void
    {
        $uuid = Uuid::generate();

        self::assertInstanceOf(Uuid::class, $uuid);
    }

    public function testGeneratedUuidsAreDifferent(): void
    {
        $first = Uuid::generate();
        $second = Uuid::generate();

        self::assertFalse($first->equals($second));
    }

    public function testCanBeConvertedToString(): void
    {
        $uuid = Uuid::generate();

        self::assertMatchesRegularExpression(
            '/^[0-9a-f-]{36}$/i',
            $uuid->toString(),
        );
    }

    public function testCanBeCreatedFromString(): void
    {
        $string = '0197c0b3-9b65-74b2-a4aa-3d7d6c7e2d53';

        $uuid = Uuid::fromString($string);

        self::assertSame($string, $uuid->toString());
    }
}
