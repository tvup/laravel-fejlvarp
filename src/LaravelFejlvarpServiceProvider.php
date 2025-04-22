<?php

namespace Tvup\LaravelFejlvarp;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tvup\LaravelFejlvarp\Components\Ago;

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
            ->hasRoutes(['web', 'api'])
            ->hasAssets()
            ->hasViews()
            ->hasViewComponents('fejlvarp', Ago::class)
            ->hasMigration('create_incidents_table')
            ->publishesServiceProvider('LaravelFejlvarpServiceProvider')
            ->runsMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->info('Publishing Fejlvarp...');
                    })
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->copyAndRegisterServiceProviderInApp()
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Have a great day!');
                    });
            });
    }

}
