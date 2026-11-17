<?php

namespace JeffersonGoncalves\LgpdVendors\Tests;

use JeffersonGoncalves\LgpdVendors\LgpdVendorsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LgpdVendorsServiceProvider::class,
        ];
    }
}
