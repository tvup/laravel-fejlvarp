# Changelog

All notable changes to `Laravel-Fejlvarp` will be documented in this file.

683d0d6

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
