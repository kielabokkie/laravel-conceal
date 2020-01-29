<?php

namespace Kielabokkie\LaravelConceal\Facades;

use Illuminate\Support\Facades\Facade;

class Concealer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'concealer';
    }
}
