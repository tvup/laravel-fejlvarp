# Simple incident logger for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tvup/laravel-fejlvarp.svg?style=flat-square)](https://packagist.org/packages/tvup/laravel-fejlvarp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/tvup/laravel-fejlvarp/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/tvup/laravel-fejlvarp/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/tvup/laravel-fejlvarp/php-cs-fixer.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/tvup/laravel-fejlvarp/actions?query=workflow%3A"Check+&20+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/tvup/laravel-fejlvarp.svg?style=flat-square)](https://packagist.org/packages/tvup/laravel-fejlvarp)

Laravel Fejlvarp is an incident logger for Laravel.

The tool provides you with a place to log runtime errors.

The service can notify when an incident first happens or is reopened via mail or through pushover.net.

It offers a web based interface to see debug info about the incident:

| Incidents overview                                                                                                           | Incident detail view                                                                                                         |
|------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------|
| <img src="https://user-images.githubusercontent.com/4526352/224930377-17f8889c-99fa-4ca0-a049-d182f6c3bbe0.png" width="500"> | <img src="https://user-images.githubusercontent.com/4526352/224930490-f0607982-737a-414d-b8b4-95de3c36f790.png" width="500"> |


## Contributors

This package is an enchancement of [Fejlvarp](https://github.com/troelskn/fejlvarp) by [troelskn](https://github.com/troelskn). Thanks for letting me envolve on the idea to letting it become a package for laravel.

## Versions
Major versions follows Laravel versions.

## Installation

You can install the package via composer:

```bash
composer require tvup/laravel-fejlvarp
```

Default route to overview will be http://your-url.top/incidents

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-fejlvarp-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-fejlvarp-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-fejlvarp-views"
```

You can replace your exception-handler
Replace 
```
$app->singleton(
	'Illuminate\Contracts\Debug\ExceptionHandler',
	'App\Exceptions\Handler'
);
```
with
```
$app->singleton(
	'Illuminate\Contracts\Debug\ExceptionHandler',
	'Tvup\LaravelFejlvarp\Exceptions\Handler'
);
```

You can have other applications report to the one you install it on, get inspiration from
/src/Exceptions/Handler.php
```php
$hash = config('app.name')
            . $exception->getMessage()
            . preg_replace('~revisions/[0-9]{14}/~', '--', $exception->getFile())
            . $exception->getLine();
        $data = [
            'hash' => md5($hash),
            'subject' => $exception->getMessage() ? $exception->getMessage() : 'Subject is empty',
            'data' => json_encode([
                'application' => config('app.name'),
                'error' => [
                    'type' => get_class($exception),
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                ],
                'environment' => [
                    'GET' => $_GET ?: null,
                    'POST' => $_POST ?: null,
                    'SERVER' => $_SERVER ?: null,
                    'SESSION' => $_SESSION ?? null,
                ],
            ], JSON_THROW_ON_ERROR),
        ];
        $request = Request::create(
            '/api/incidents', 
            'POST', 
            $data, 
            [], 
            [], 
            ['CONTENT_TYPE'=>'application/x-www-form-urlencoded']
        );
        app()->handle($request);
``` 

## Usage

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
