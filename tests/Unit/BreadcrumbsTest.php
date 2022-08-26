<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
use Mockery\MockInterface;
use Tests\TestCase;
use WireUi\Breadcrumbs\{Breadcrumbs, Trail};

class BreadcrumbsTest extends TestCase
{
    public function test_it_should_get_the_breadcrumbs_from_route()
    {
        $breadcrumbs = (new Trail())
            ->push('Test', 'http://test.com')
            ->push('Test 2', 'http://test2.com');

        $route = new Route(['GET'], 'test', fn () => '');

        $route->breadcrumbs = fn () => $breadcrumbs;

        /** @var MockInterface|Request */
        $request = $this->partialMock(Request::class)
            ->shouldReceive('route')
            ->andReturn($route)
            ->getMock();

        $component = new Breadcrumbs($request);

        $this->assertEquals($breadcrumbs->toArray(), $component->breadcrumbs);
    }

    public function test_it_should_get_the_breadcrumbs_from_session()
    {
        $data = [
            ['label' => 'Test', 'url' => 'http://test.com'],
            ['label' => 'Test 2', 'url' => 'http://test2.com'],
        ];

        session()->put(Breadcrumbs::EVENT, $data);

        /** @var Breadcrumbs $component */
        $component = resolve(Breadcrumbs::class);

        $this->assertSame($data, $component->breadcrumbs);
    }

    /** @dataProvider homeRouteProvider */
    public function test_it_should_set_and_render_the_home_route($route)
    {
        config()->set('wireui.breadcrumbs.home', $route);

        $html = Blade::render('<x-breadcrumbs />');

        $this->assertStringContainsString('href="https://example.com"', $html);
    }

    public function homeRouteProvider(): array
    {
        return [
            ['https://example.com'],
            [fn () => 'https://example.com'],
        ];
    }
}
