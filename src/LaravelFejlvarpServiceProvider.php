<?php

namespace Tvup\LaravelFejlvarp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tvup\LaravelFejlvarp\View\Components\Ago;

class LaravelFejlvarpServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-fejlvarp')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponents('laravel-fejlvarp', Ago::class)
            ->hasRoutes(['web', 'api'])
            ->hasMigration('create_incidents_table');
    }
}
