# Changelog

All notable changes to `Laravel-Fejlvarp` will be documented in this file.

683d0d6

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
