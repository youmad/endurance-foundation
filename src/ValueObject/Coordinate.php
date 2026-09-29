<?php

declare(strict_types=1);

namespace Youmad\Endurance\Foundation\ValueObject;

use Youmad\Endurance\Foundation\Exception\InvalidCoordinate;

final readonly class Coordinate
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {
        if (
            false === is_finite($this->latitude)
            || -90.0 > $this->latitude
            || 90.0 < $this->latitude
        ) {
            throw new InvalidCoordinate('Latitude must be a finite number between -90 and 90 degrees.');
        }

        if (
            false === is_finite($this->longitude)
            || -180.0 > $this->longitude
            || 180.0 < $this->longitude
        ) {
            throw new InvalidCoordinate('Longitude must be a finite number between -180 and 180 degrees.');
        }
    }
}
