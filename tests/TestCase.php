<?php

namespace Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench;
use ReflectionClass;
use WireUi\Breadcrumbs\ServiceProvider;

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
            ServiceProvider::class,
        ];
    }

    /** Get protected/private property value of a class */
    public function invadeProperty(mixed $object, string $property)
    {
        $reflection = new ReflectionClass(get_class($object));
        $property   = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
