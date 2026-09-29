# youmad/endurance-foundation

Small, framework-agnostic primitives shared by endurance activity libraries.

The package provides explicit types for concepts that should not be represented
by unvalidated strings, numbers, or mutable date-time objects.

## Features

- immutable instants and non-negative durations with microsecond precision;
- validated geographic coordinates;
- UUID v7 generation and parsing;
- explicit temporal resolution;
- production and deterministic clock implementations.

## Requirements

- PHP 8.5;
- Symfony UID 8.

## Installation

Install the package with Composer:

```bash
composer require youmad/endurance-foundation
```

## Usage

```php
<?php

declare(strict_types=1);

use DateTimeImmutable;
use Youmad\Endurance\Foundation\ValueObject\Coordinate;
use Youmad\Endurance\Foundation\ValueObject\Duration;
use Youmad\Endurance\Foundation\ValueObject\Instant;
use Youmad\Endurance\Foundation\ValueObject\Uuid;

require __DIR__.'/vendor/autoload.php';

$startedAt = Instant::fromDateTimeImmutable(
    new DateTimeImmutable('2026-09-10T18:00:00.000000Z'),
);
$finishedAt = Instant::fromDateTimeImmutable(
    new DateTimeImmutable('2026-09-10T18:45:00.250000Z'),
);

$duration = Duration::between($startedAt, $finishedAt);
$coordinate = new Coordinate(latitude: 59.437, longitude: 24.7536);
$id = Uuid::generate();
```

Invalid durations and coordinates fail at construction time. Value objects do
not silently normalize invalid input.

## Clocks

`SystemClock` reads the current time. `FrozenClock` provides a deterministic
instant for tests and other repeatable workflows. Both implement the small
`Clock` interface.

## Development

```bash
composer install
composer check
```

`composer check` validates the package metadata, runs PHPUnit and PHPStan
(level 6), and checks the code style with PHP CS Fixer (`@Symfony`).

Run individual checks or apply code-style fixes with:

```bash
composer test
composer analyse
composer cs:check
composer cs:fix
```

## License

The project-authored source code, tests, and documentation in this package
are licensed under the Mozilla Public License 2.0 (`MPL-2.0`).

> This Source Code Form is subject to the terms of the Mozilla Public
> License, v. 2.0. If a copy of the MPL was not distributed with this
> file, You can obtain one at https://mozilla.org/MPL/2.0/.

See [LICENSE](LICENSE). Dependencies retain their own licenses.
