<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\Tests\ValueObject;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Youmad\Endurance\Foundation\Exception\InvalidCoordinate;
use Youmad\Endurance\Foundation\ValueObject\Coordinate;

final class CoordinateTest extends TestCase
{
    public function testCanCreateCoordinate(): void
    {
        $coordinate = new Coordinate(
            latitude: 59.4369,
            longitude: 24.7535,
        );

        self::assertSame(
            59.4369,
            $coordinate->latitude,
        );

        self::assertSame(
            24.7535,
            $coordinate->longitude,
        );
    }

    #[DataProvider('validCoordinatesProvider')]
    public function testCanCreateCoordinateAtValidBoundaries(
        float $latitude,
        float $longitude,
    ): void {
        $coordinate = new Coordinate(
            latitude: $latitude,
            longitude: $longitude,
        );

        self::assertSame(
            $latitude,
            $coordinate->latitude,
        );

        self::assertSame(
            $longitude,
            $coordinate->longitude,
        );
    }

    /**
     * @return iterable<string, array{
     *     latitude: float,
     *     longitude: float
     * }>
     */
    public static function validCoordinatesProvider(): iterable
    {
        yield 'minimum values' => [
            'latitude' => -90.0,
            'longitude' => -180.0,
        ];

        yield 'maximum values' => [
            'latitude' => 90.0,
            'longitude' => 180.0,
        ];

        yield 'zero values' => [
            'latitude' => 0.0,
            'longitude' => 0.0,
        ];
    }

    #[DataProvider('invalidLatitudesProvider')]
    public function testCannotCreateCoordinateWithInvalidLatitude(
        float $latitude,
    ): void {
        $this->expectException(
            InvalidCoordinate::class,
        );

        new Coordinate(
            latitude: $latitude,
            longitude: 24.7535,
        );
    }

    /**
     * @return iterable<string, array{latitude: float}>
     */
    public static function invalidLatitudesProvider(): iterable
    {
        yield 'below minimum' => [
            'latitude' => -90.000001,
        ];

        yield 'above maximum' => [
            'latitude' => 90.000001,
        ];

        yield 'positive infinity' => [
            'latitude' => INF,
        ];

        yield 'negative infinity' => [
            'latitude' => -INF,
        ];

        yield 'not a number' => [
            'latitude' => NAN,
        ];
    }

    #[DataProvider('invalidLongitudesProvider')]
    public function testCannotCreateCoordinateWithInvalidLongitude(
        float $longitude,
    ): void {
        $this->expectException(
            InvalidCoordinate::class,
        );

        new Coordinate(
            latitude: 59.4369,
            longitude: $longitude,
        );
    }

    /**
     * @return iterable<string, array{longitude: float}>
     */
    public static function invalidLongitudesProvider(): iterable
    {
        yield 'below minimum' => [
            'longitude' => -180.000001,
        ];

        yield 'above maximum' => [
            'longitude' => 180.000001,
        ];

        yield 'positive infinity' => [
            'longitude' => INF,
        ];

        yield 'negative infinity' => [
            'longitude' => -INF,
        ];

        yield 'not a number' => [
            'longitude' => NAN,
        ];
    }
}
