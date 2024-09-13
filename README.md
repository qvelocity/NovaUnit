# NovaUnit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/quotevelocity/novaunit.svg?style=flat-square)](https://packagist.org/packages/quotevelocity/novaunit)
<!-- [![Code Coverage](https://scrutinizer-ci.com/g/quotevelocity/novaunit/badges/coverage.png)](https://scrutinizer-ci.com/g/joshgaber/novaunit/)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/quotevelocity/novaunit/badges/quality-score.png)](https://scrutinizer-ci.com/g/joshgaber/novaunit/) -->
[![Total Downloads](https://img.shields.io/packagist/dt/quotevelocity/novaunit.svg?style=flat-square)](https://packagist.org/packages/joshgaber/novaunit)

[NovaUnit](https://joshgaber.github.io/NovaUnit) is a unit-testing package for Laravel Nova, built using PHPUnit. NovaUnit provides you with assertions for Nova Actions, Lenses and Resources, so you can create great administration panels with confidence.

NovaUnit is a fork of the brilliant original package by [Josh Gaber](https://github.com/joshgaber) which has been updated to support the latest versions of Laravel and Nova.

## Installation

You can install the package in your Laravel Project via composer:

```sh
composer require --dev quotevelocity/novaunit
```

### Requirements

* PHP 8.0 or higher
* [Laravel](https://laravel.com/) 9.x - 11.x
* [Laravel Nova](https://nova.laravel.com/) 4.x or higher
* [PHPUnit](https://github.com/sebastianbergmann/phpunit) 9.x - 11.x

Note: For older projects (Laravel < 9, Nova 2 or 3) please see the legacy project: [`joshgaber/novaunit`](https://github.com/joshgaber/NovaUnit) instead.

## Usage

To access the test classes, import and use the base test traits:

```php
class ClearLogsTest extends TestCase {
    use NovaActionTest;
}
```

Once you've created the mock with the initial test class, you can begin testing different aspect of the component:

```php
$this->novaAction(ClearLogs::class)
    ->assertHasField('since_date');
```

For a list of available methods, see the [full docs site](https://joshgaber.github.io/NovaUnit).

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email rob _at_ `quotevelocity`.com instead of using the issue tracker.

## Maintained By
* [Robert Marney](https://github.com/robertmarney) (Maintainer)

## Created By

* [Josh Gaber](https://github.com/joshgaber) (Creator)

## Contributors

* [Joshua Lauwrich Nandy](https://github.com/joshua060198)
* [nicko170](https://github.com/nicko170)
* [Henry Ávila](https://github.com/henryavila)
* [Peter Elmered](https://github.com/pelmered)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
