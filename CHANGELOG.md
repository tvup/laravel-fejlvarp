# Changelog

All notable changes to `Laravel-Fejlvarp` will be documented in this file.

683d0d6

## v11.0.0 - 2024-01-20

### What's Changed

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v10.2.6...v11.0.0

#### Breaking changes

- **Remove `dontReport` field from handler** - It's not something the package should deal with; it's, of course, up to the user to choose these things.
- **Remove `dontFlash` field from handler** - It's not something the package should deal with; it's, of course, up to the user to choose these things. Besides, Laravel already has a suggestion for this field in the raw installation - even more reason not to override it.
- **Extend the Handler in the user's installation instead of the Laravel one** - We don't want to just ignore what the user has in his/her `Handler.php`.

*The behaviour after updating from previuos may dramatically change since your own Handler.php is now used again.*

## v10.2.6 - 2023-10-25

### What's Changed

**Full Changelog**: [https://github.com/tvup/laravel-fejlvarp/compare/v10.2.5.10...v10.2.6](https://github.com/tvup/laravel-fejlvarp/compare/v10.2.5.10...v10.2.6)

#### Primarily Under-the-Hood Changes

- **Middleware Update**: Removed the "admin" middleware attachment from routes.
- **Installation Ease**: Enhanced the installation process to ensure users can set up the package with minimal effort.
- **Dependencies**: Updated various 3rd party packages to their latest versions.

## v10.2.5.3 - 2023-08-02

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v10.2.5.2...v10.2.5.3

## v10.2.5.2 - 2023-08-02

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v10.2.5.1...v10.2.5.2

## v10.2.5.1 - 2023-08-02

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v9.1.4...v10.2.5.1

### Bugfix

## v10.2.5 - 2023-08-02

### What's Changed

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v9.1.4...v10.2.5
Laravel v10 campatible

## v9.1.5 - 2023-03-28

### What's Changed

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v9.1.4...v9.1.5

#### Bugfix

Fixes bug where all exceptions received were notified upon not just on new or reopen events

## v9.1.4 - 2023-03-17

### What's Changed

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v9.1.3...v9.1.4

#### Bugfix

Fixes bug were resolved_at wasn't set to null

## v9.1.3 - 2023-03-16

### What's Changed

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v9.1.1...v9.1.3

#### Bugfix

Fixes bug where every incident made a notication and not just for open/reopen

## v9.1.2 - 2023-03-16

Fixes bug where incidents weren't reopened

## v9.1.1 - 2023-03-14

### What's Changed

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v9.1.0...v9.1.1

#### Minor changes

- Adds type-hint for method fejlvarp_exception_handler. Corrects php-doc for function render
- Upgrade testbench version in test-flow for gh actions
- Adds missing phpunit.xml
- Up minimum stability

## v9.1.0 - 2023-03-14

### What's Changed

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v9.0.4...v9.1.0

#### Bugfixes

- ipstack was never called, as a check for netmask of IP had wrong is_numeric criteria.
- Corrects test-workflow in gh actions
- Corrects changelog-flow in gh actions

#### Improvements

- Improced readme
- Get app-name from config for hash-calculation and application name in incident view

#### New functionality

- Added exception-handler with functionality to call report to incident manager

#### Deprecations

- Remove dependabot
