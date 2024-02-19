<?php

namespace Tests\Unit\ServiceProvider;

use Livewire\Livewire;
use Tests\TestCase;
use Tests\Unit\ServiceProvider\Livewire\ComponentWithBreadcrumbs;
use WireUi\Breadcrumbs\Components\Tallstack;

class DontRegisterLivewireListenersTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wireui.breadcrumbs.livewire.listeners', false);
    }

    public function test_should_not_register_the_livewire_listeners()
    {
         Livewire::test(new ComponentWithBreadcrumbs());

        $this->assertNull(
            session()->get(Tallstack::EVENT),
        );
    }
}
