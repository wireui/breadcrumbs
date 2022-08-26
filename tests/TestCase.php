<?php

namespace Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench;
use WireUi\Breadcrumb\BreadcrumbServiceProvider;

class TestCase extends Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        app('session')->put('_token', 'fake-token-for-testing');
        config()->set('app.key', 'base64:ybwMUpvbFVa73CgNQqRAsBBA6Tx08Bnt1ZHRwzhMbwc=');
        config()->set('app.debug', true);
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            BreadcrumbServiceProvider::class,
        ];
    }
}
