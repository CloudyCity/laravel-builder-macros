# Laravel Builder Macros

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![StyleCI][ico-styleci]][link-styleci]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Installation
Require this package with composer using the following command:
```bash
composer require cloudycity/laravel-builder-macros
```
After updating composer, add the service provider to the `providers` array in `config/app.php`
```bash
CloudyCity\LaravelBuilderMacros\Providers\DatabaseServiceProvider::class,
```
**Laravel 5.5** uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

## Requirement
- PHP 5.6 +

## Usage
```php
$query->insertUpdate($data);
// INSERT INTO TABLE ... VALUES ... ON DUPLICATE KEY UPDATE ...

$query->replace($data);
// REPLACE INTO TABLE ... VALUES ...

$query->insertIgnore($data);
// INSERT IGNORE INTO TABLE ... VALUES ...

$query->whereIntegerInRaw('uid', ['1', '2'])->get();
// for the old version
```

## License

MIT


[ico-version]: https://img.shields.io/packagist/v/cloudycity/laravel-builder-macros.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/cloudycity/laravel-builder-macros/master.svg?style=flat-square
[ico-code-coverage]: https://img.shields.io/scrutinizer/coverage/g/cloudycity/laravel-builder-macros.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/226231265/shield?branch=master
[ico-code-quality]: https://img.shields.io/scrutinizer/g/cloudycity/laravel-builder-macros.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cloudycity/laravel-builder-macros.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/cloudycity/laravel-builder-macros
[link-travis]: https://travis-ci.org/cloudycity/laravel-builder-macros
[link-code-coverage]: https://scrutinizer-ci.com/g/cloudycity/laravel-builder-macros/code-structure
[link-styleci]: https://styleci.io/repos/226231265
[link-code-quality]: https://scrutinizer-ci.com/g/cloudycity/laravel-builder-macros
[link-downloads]: https://packagist.org/cloudycity/laravel-builder-macros
[link-author]: https://github.com/cloudycity
