# Simple incident logger for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tvup/laravelfejlvarp.svg?style=flat-square)](https://packagist.org/packages/tvup/laravelfejlvarp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/tvup/laravelfejlvarp/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/tvup/laravelfejlvarp/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/tvup/laravelfejlvarp/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/tvup/laravelfejlvarp/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/tvup/laravelfejlvarp.svg?style=flat-square)](https://packagist.org/packages/tvup/laravelfejlvarp)

Laravel Fejlvarp is an incident logger for Laravel.

The tool provides you with a place to log runtime errors.

The service can notify when an incident first happens or is reopened via mail or through pushover.net.

It offers a web based interface to see debug info about the incident.

## Contributors

This package is an enchancement of [Fejlvarp](https://github.com/troelskn/fejlvarp) by [troelskn](https://github.com/troelskn). Thanks for letting me envolve on the idea to letting it become a package for laravel.

## Versions
Major versions follows Laravel versions.

## Installation

You can install the package via composer:

```bash
composer require tvup/laravelfejlvarp
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravelfejlvarp-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravelfejlvarp-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravelfejlvarp-views"
```

## Usage

```php
$laravelFejlVarp = new Tvup\LaravelFejlVarp();
echo $laravelFejlVarp->echoPhrase('Hello, Tvup!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Torben Evald Hansen](https://github.com/tvup)
- [Troels Knak-Nielsen](https://github.com/troelskn)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
