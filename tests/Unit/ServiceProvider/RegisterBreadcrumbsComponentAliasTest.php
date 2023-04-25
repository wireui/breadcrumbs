<?php

namespace Tests\Unit\ServiceProvider;

use Illuminate\View\Compilers\BladeCompiler;
use Tests\TestCase;
use WireUi\Breadcrumbs\Components\Tallstack;

class RegisterBreadcrumbsComponentAliasTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wireui.breadcrumbs.alias', 'custom-name');
    }

    public function test_should_register_the_breadcrumbs_blade_component_with_a_custom_alias()
    {
        /** @var BladeCompiler $bladeCompiler */
        $bladeCompiler = resolve(BladeCompiler::class);

        $aliases = $bladeCompiler->getClassComponentAliases();

        $this->assertArrayHasKey('custom-name', $aliases, 'The custom alias should be registered');
        $this->assertSame($aliases['custom-name'], Tallstack::class);
    }
}
