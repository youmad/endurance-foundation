<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\ValueObject\Uuid;

final class UuidTest extends TestCase
{
    public function testGeneratesVersionSevenUuid(): void
    {
        $uuid = Uuid::generate();

        self::assertMatchesRegularExpression(
            '/\A[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}\z/i',
            $uuid->toString(),
        );
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
