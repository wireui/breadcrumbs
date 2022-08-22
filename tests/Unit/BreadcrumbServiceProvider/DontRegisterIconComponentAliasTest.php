<?php

namespace Tests\Unit\BreadcrumbServiceProvider;

use Illuminate\View\Compilers\BladeCompiler;
use Tests\TestCase;

class DontRegisterIconComponentAliasTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wireui.breadcrumb.alias', false);
    }

    public function test_should_not_register_the_icon_component()
    {
        /** @var BladeCompiler $bladeCompiler */
        $bladeCompiler = resolve(BladeCompiler::class);

        $aliases = $bladeCompiler->getClassComponentAliases();

        $this->assertArrayNotHasKey('breadcrumb', $aliases, "The custom alias shouldn't be registered");
    }
}
