# Changelog

All notable changes to `Laravel-Fejlvarp` will be documented in this file.

683d0d6

## v11.1.7 - 2025-02-01

### What's Changed

* Ensure correct content-type for useragent-lookip by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/53

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v11.1.6...v11.1.7

## v11.1.6 - 2025-02-01

### What's Changed

* update phpstan and check tests by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/50
* Update dependency larastan/larastan to v3.0.2 by @renovate in https://github.com/tvup/laravel-fejlvarp/pull/51
* Update larastan to include version 3.0.2 by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/52

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v11.1.5...v11.1.6

## v11.1.5 - 2025-02-01

#### **Description:**

This version introduces support for **PHP 8.4** and improves test coverage for Laravel Fejlvarp. It includes:

- **Support for PHP 8.4** in the GitHub Actions workflow.
- **Refactoring of the GeoIP lookup function** to use `Http::get()` instead of `file_get_contents()`, ensuring better error handling and maintainability.
- **Content-Type fix for the GeoIP response**, explicitly setting it to `application/javascript`.
- **Addition of new feature tests** for API endpoints, increasing overall test coverage.
- **Fixture-based testing for incidents**, improving consistency in tests.
- **Database configuration updates** for SQLite in-memory testing.
- **Dependency updates**, including `guzzlehttp/guzzle` and `orchestra/testbench`.
- **Allowing auto-merge for patch dependencies** in `renovate.json`.

#### **Key Changes:**

- **Modified:** [[.github/workflows/run-tests.yml](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/.github%2Fworkflows%2Frun-tests.yml)](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/.github%2Fworkflows%2Frun-tests.yml) → Added PHP 8.4 to the test matrix.
- **Modified:** [[IncidentController.php](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/src%2FHttp%2FControllers%2FApi%2FIncidentController.php)](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/src%2FHttp%2FControllers%2FApi%2FIncidentController.php) → Replaced `file_get_contents()` with `Http::get()`.
- **Added:** [[Feature tests for GeoIP lookup](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/tests%2FFeature%2FHttp%2FControllers%2FApi%2FIncidentControllerTest.php)](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/tests%2FFeature%2FHttp%2FControllers%2FApi%2FIncidentControllerTest.php).
- **Added:** [[Fixture files](https://github.com/tvup/laravel-fejlvarp/tree/04cfb5433d112f492ec2932c1702bef705ed1966/tests/Fixtures)](https://github.com/tvup/laravel-fejlvarp/tree/04cfb5433d112f492ec2932c1702bef705ed1966/tests/Fixtures) for structured test data.
- **Modified:** [[composer.json](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/composer.json)](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/composer.json) → Updated dependencies for PHP 8.4 compatibility.
- **Modified:** [[TestCase.php](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/tests%2FTestCase.php)](https://github.com/tvup/laravel-fejlvarp/blob/04cfb5433d112f492ec2932c1702bef705ed1966/tests%2FTestCase.php) → Configured SQLite in-memory database for tests.

#### **Additional Notes:**

This version ensures **forward compatibility with PHP 8.4** and strengthens test reliability by introducing **fixtures and additional test cases**. 🚀

### What's Changed

* Add user data to incident reports by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/44
* Migrate renovate config by @renovate in https://github.com/tvup/laravel-fejlvarp/pull/46
* Release 2025Q1-1 by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/48

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v11.1.4...v11.1.5

## v11.1.4 - 2024-07-27

### What's Changed

* Update actions/checkout action to v4 by @renovate in https://github.com/tvup/laravel-fejlvarp/pull/19
* Update stefanzweifel/git-auto-commit-action action to v5 by @renovate in https://github.com/tvup/laravel-fejlvarp/pull/18
* Refactoring, Dependency Management, and Enhanced Logging Features (#42) by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/43
* Add user data to incident reports (#44) by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/45

#### Enhancements and Updates

1. **GitHub Actions Workflow Enhancements**:
   
   - Updated the `actions/checkout` action from version 3 to 4 across multiple workflows for improved performance and security.
   - Removed unnecessary permissions in the `php-cs-fixer.yml` workflow, enhancing security.
   
2. **PHPStan Workflow Improvements**:
   
   - Updated PHP version to `8.3` for PHPStan analysis.
   - Replaced `nunomaduro/larastan` with `larastan/larastan`, ensuring up-to-date static analysis capabilities.
   
3. **Testing Workflow Enhancements**:
   
   - Introduced environment-specific handling for Composer dependencies installation in the `run-tests.yml` workflow, with specific commands for Linux and Windows environments.
   - Improved error handling during the installation of dependencies to provide clearer feedback in case of issues.
   
4. **Changelog Update Automation**:
   
   - Upgraded `stefanzweifel/git-auto-commit-action` to version 5 in the `update-changelog.yml` workflow for improved performance and bug fixes.
   
5. **New Features in Application**:
   
   - Introduced `IncidentFactory` for streamlined creation and management of `Incident` models, supporting better testing and data management.
   
6. **Database Query Logging**:
   
   - Added logging for database queries in incident reports, providing detailed insights into query performance and database interactions.
   
7. **Apllication data logging**:
   
   - Enhanced error logging by including authenticated user data in the incident reports if applicable. This includes capturing user-related data in the error context.
   
8. **Additional Tags and Metadata**:
   
   - Added "negoziator" to the list of keywords in `composer.json`, acknowledging contribution.
   
9. **Miscellaneous:**
   
   - Refined the validation rules return type in `IncidentStoreRequest.php` for improved type hinting and code clarity.
   - Various minor fixes and updates to ensure compatibility with Laravel 10 and improved error handling.
   - Fixed minor code documentation issues, enhancing clarity and accuracy in codebase annotations.
   

This release focuses on enhancing the robustness, security, and maintainability of the project, providing a better foundation for future development, improving compatibility, enhancing error handling, and updating dependencies to leverage the latest features and best practices in the Laravel ecosystem.

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v11.1.3...v11.1.4

## v11.1.3 - 2024-07-27

### What's Changed

* Update README and refactor time functions (#40) by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/41

**Enhancements:**

- **Documentation Update:** Acknowledged [negoziator](https://github.com/negoziator) for contributions in README.md.
- **New Section in README:** Added detailed instructions for local development and testing of `laravel-fejlvarp` through a Laravel application, including Docker setup and Composer configuration.

**Codebase Changes:**

- **Timezone Configuration:** Removed hardcoded timezone settings. The package now defaults to using the application's configured timezone, giving the implementing application full control over timezone settings.
- **Removal of Carbon Dependency:** Replaced usage of `Carbon` with the native `now()` helper for handling date and time, enhancing compatibility and reducing external dependencies.

**Contributors:**

- Added Lars Christian Schou to `composer.json` as a contributor to the project.

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v11.1.2...v11.1.3

## v11.1.2 - 2024-07-27

### What's Changed

* Compatibility clarified: PHP versions >8.0.2 and 8.3+ by @tvup in https://github.com/tvup/laravel-fejlvarp/pull/31
* Modified PHP CS Fixer workflow to use --dry-run instead of committing changes automatically

### Release Summary

This release clarifies and documents the specific requirements and compatibility for our project, ensuring they are explicitly defined and understood by all users and contributors. The key updates include:

1. **PHP Version Requirements:**
   
   - The minimum PHP version requirement is now explicitly set to 8.0.2, indicating the project's reliance on features available from this version onward. Official support is confirmed for PHP versions 8.0.2, 8.1, 8.2, and 8.3, ensuring optimal functionality across these environments.
   - The package now officially supports PHP version 8.0.2 and above, with updated PHP version constraints and verification of dependency compatibility to accommodate these versions.
   
2. **Laravel Compatibility:**
   
   - Compatibility with Laravel versions ^9.47, 10.*, and 11.* is now explicitly documented, along with the corresponding `orchestra/testbench` versions (7.*, 8.*, 9.* respectively). This clarifies the frameworks and testing environments that the project supports.
   
3. **Required PHP Extensions:**
   
   - The requirement for the `ext-curl` extension is now explicitly stated in `require-dev`. This extension is necessary due to its dependency in `spatie/laravel-ray` and `spatie/ray`. Documenting this requirement helps prevent potential runtime errors during development and testing.
   
4. **Testing and CI/CD Enhancements:**
   
   - The GitHub Actions workflow has been enhanced to test a comprehensive matrix of PHP versions (8.0.2 to 8.3), Laravel versions (^9.47, 10.*, 11.*), and `testbench` versions (7.*, 8.*, 9.*) across multiple operating systems (Ubuntu and Windows).
   - Adjustments ensure that `testbench package:discover` only runs when dev dependencies are present, using a PHP-based check.
   
5. **General Improvements:**
   
   - `composer.json` has been updated to reflect the new minimum PHP version and the addition of `ext-curl` in `require-dev`.
   - The PHP CS Fixer workflow has been adjusted to remove the auto-commit of fixed styling changes. The workflow now runs with the `--dry-run` flag, ensuring that no changes are automatically committed. This adjustment provides greater control over code style corrections and allows developers to review changes before committing.
   

These updates clarify the project's existing requirements, provide explicit documentation, and ensure consistent understanding across all development and deployment environments. Additionally, they enhance our CI/CD processes to ensure better coverage and reliability while keeping the package up-to-date with the latest PHP developments and ready for future versions.

### Breaking Changes

This release aims to clarify and disallow certain combinations that may have been possible previously, though unlikely. It is possible that some edge cases, particularly with Laravel versions from 9.0.0 up to, but not including, 9.47.0, may have allowed a set of requirements and installations that are no longer permissible as of this release.
**We expect no breaking changes but please be aware and report any issues if they arise.**

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v11.1.1...v11.1.2

## v11.1.1 - 2024-06-30

### What's Changed

* Use Laravels base handler by @negoziator in https://github.com/tvup/laravel-fejlvarp/pull/21

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v11.1.0...v11.1.1

## Support for Laravel 11 - 2024-06-30

### What's Changed

* Add support for laravel 11 by @negoziator in https://github.com/tvup/laravel-fejlvarp/pull/20

### New Contributors

* @negoziator made their first contribution in https://github.com/tvup/laravel-fejlvarp/pull/20

**Full Changelog**: https://github.com/tvup/laravel-fejlvarp/compare/v11.0.0...v11.1.0

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
