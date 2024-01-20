# Laravel Fejlvarp: Your Go-To Incident Logger

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tvup/laravel-fejlvarp.svg?style=flat-square)](https://packagist.org/packages/tvup/laravel-fejlvarp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/tvup/laravel-fejlvarp/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/tvup/laravel-fejlvarp/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/tvup/laravel-fejlvarp/php-cs-fixer.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/tvup/laravel-fejlvarp/actions?query=workflow%3A"Check+&20+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/tvup/laravel-fejlvarp.svg?style=flat-square)](https://packagist.org/packages/tvup/laravel-fejlvarp)

Laravel Fejlvarp is a robust incident logger tailored for Laravel applications. Designed to streamline error tracking, it ensures that you're always in the loop about runtime errors, allowing for swift resolution.

**Why Choose Laravel Fejlvarp?**

- **Instant Notifications:** Get notified immediately when an incident occurs or is reopened via email or pushover.net.
- **Intuitive Interface:** A user-friendly web interface lets you delve deep into debug information about each incident.
- **Seamless Integration:** Designed to fit right into your Laravel application without any hassle.


| Incidents overview                                                                                                           | Incident detail view                                                                                                         |
|------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------|
| <img src="https://user-images.githubusercontent.com/4526352/224930377-17f8889c-99fa-4ca0-a049-d182f6c3bbe0.png" width="500"> | <img src="https://user-images.githubusercontent.com/4526352/224930490-f0607982-737a-414d-b8b4-95de3c36f790.png" width="500"> |


## Contributors

This package is an enchancement of [Fejlvarp](https://github.com/troelskn/fejlvarp) by [troelskn](https://github.com/troelskn). Thanks for letting me envolve on the idea to letting it become a package for laravel.

## Versions
~~Major versions follows Laravel versions.~~

Previously, major versions followed Laravel versions. However, this practice was identified as an anti-pattern and has since been discontinued.

Starting from version 11, the corresponding Laravel version requirement is explicitly stated in the `composer.json` file.

## Installation

You can install the package via composer:

```bash
composer require tvup/laravel-fejlvarp
```

Default route to list of incidents will be http://your-url.top/incidents

**Important! Make sure to protect this route with (admin) authentication**

You can enjoy the convenience of letteing the package install itsleft
```bash
php artisan fejlvarp:install
```
It will also ask you if you want to create (migrate) the table that will be storing the incidents


Instead of doing the above, or just if you are curious, you publish the files manually by doing the following:

You can publish and run the migrations with:
```bash
php artisan vendor:publish --tag="fejlvarp-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --tag="fejlvarp-config"
```

This is the contents of the published config file:

```php
return [
    'ipstack' => ['access_key' => env('INCIDENT_MANAGER_IPSTACK_ACCESS_KEY')],

    'pushover' => [
        'userkey' => env('INCIDENT_MANAGER_PUSHOVER_USER_KEY'),
        'apitoken' => env('INCIDENT_MANAGER_PUSHOVER_API_TOKEN'),
    ],

    'slack' => [
        'webhook_url' => env('INCIDENT_MANAGER_SLACK_WEBHOOK_URL'),
    ],

    'mail_recipient' => env('INCIDENT_MANAGER_EMAIL_RECIPIENT'),
];
```

ipstack is used to get info about ip-addresses - you can retrieve an access key here: https://ipstack.com/signup/free
Results from ipstack are cached, so it won't drain the free lookups right away.

Pushover/slack/mail is used to inform about new og reopened incidents

Optionally, you can publish the views using
```bash
php artisan vendor:publish --tag="fejlvarp-views"
```

You can replace your exception-handler
Replace 
```bash
php artisan vendor:publish --tag=fejlvarp-provider
```
remember to make sure that the serivce-provider is correctly installed

You can have other applications report to the one you install it on, get inspiration from
/src/Exceptions/LaravelFejlvarpExceptionHandler.php
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
