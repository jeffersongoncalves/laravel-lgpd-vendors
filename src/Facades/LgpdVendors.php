<?php

namespace JeffersonGoncalves\LgpdVendors\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\LgpdVendors\LgpdVendors
 */
class LgpdVendors extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-lgpd-vendors';
    }
}
