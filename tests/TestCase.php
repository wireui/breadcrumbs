<?php

namespace Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench;

class TestCase extends Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
        ];
    }
}
