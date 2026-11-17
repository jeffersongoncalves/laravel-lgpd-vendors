<?php

namespace JeffersonGoncalves\LgpdVendors;

use JeffersonGoncalves\LgpdVendors\Commands\VendorsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LgpdVendorsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lgpd-vendors')
            ->hasConfigFile()
            ->hasMigrations(['create_lgpd_vendors_table'])
            ->hasCommand(VendorsCommand::class);
    }
}
