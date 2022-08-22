<?php

namespace Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench;
use WireUi\Breadcrumb\BreadcrumbServiceProvider;

class TestCase extends Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            BreadcrumbServiceProvider::class,
        ];
    }
}
