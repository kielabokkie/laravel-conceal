<?php

namespace Kielabokkie\LaravelConceal\Tests;

use Illuminate\Config\Repository;
use Kielabokkie\LaravelConceal\ConcealServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ConcealServiceProvider::class
        ];
    }

    protected function getPackageAliases($app) {
        return [
            'config' => Repository::class
        ];
    }
}
