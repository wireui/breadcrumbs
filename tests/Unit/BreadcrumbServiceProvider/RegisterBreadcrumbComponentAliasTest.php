<?php

namespace Tests\Unit\BreadcrumbServiceProvider;

use Illuminate\View\Compilers\BladeCompiler;
use Tests\TestCase;
use WireUi\Breadcrumb\Breadcrumb;

class RegisterBreadcrumbComponentAliasTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wireui.breadcrumb.alias', 'custom-icon');
    }

    public function test_should_register_the_icon_blade_component_with_a_custom_alias()
    {
        /** @var BladeCompiler $bladeCompiler */
        $bladeCompiler = resolve(BladeCompiler::class);

        $aliases = $bladeCompiler->getClassComponentAliases();

        $this->assertArrayHasKey('custom-icon', $aliases, 'The custom alias should be registered');
        $this->assertSame($aliases['custom-icon'], Breadcrumb::class);
    }
}
