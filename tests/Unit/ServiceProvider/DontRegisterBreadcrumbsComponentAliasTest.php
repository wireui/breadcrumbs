<?php

namespace Tests\Unit\ServiceProvider;

use Illuminate\View\Compilers\BladeCompiler;
use Tests\TestCase;

class DontRegisterBreadcrumbsComponentAliasTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wireui.breadcrumbs.alias', false);
    }

    public function test_should_not_register_the_breadcrumbs_component()
    {
        /** @var BladeCompiler $bladeCompiler */
        $bladeCompiler = resolve(BladeCompiler::class);

        $aliases = $bladeCompiler->getClassComponentAliases();

        $this->assertArrayNotHasKey('breadcrumbs', $aliases, "The custom alias shouldn't be registered");
    }
}
