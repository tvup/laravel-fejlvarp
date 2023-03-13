<?php

namespace Tvup\LaravelFejlVarp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tvup\LaravelFejlVarp\View\Components\Ago;

class LaravelFejlVarpServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravelfejlvarp')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponents('laravelfejlvarp', Ago::class)
            ->hasRoutes(['web', 'api'])
            ->hasMigration('create_laravelfejlvarp_table');
    }
}
