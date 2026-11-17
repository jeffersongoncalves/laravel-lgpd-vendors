<?php

namespace JeffersonGoncalves\LgpdVendors;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LgpdVendorsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-lgpd-vendors')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
