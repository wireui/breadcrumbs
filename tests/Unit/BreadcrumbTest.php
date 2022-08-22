<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
use Mockery\MockInterface;
use Tests\TestCase;
use WireUi\Breadcrumb\{Breadcrumb, Trail};

class BreadcrumbTest extends TestCase
{
    public function test_it_should_get_the_breadcrumb_from_route()
    {
        $breadcrumb = (new Trail())
            ->push('Test', 'http://test.com')
            ->push('Test 2', 'http://test2.com');

        $route = new Route(['GET'], 'test', fn () => '');

        $route->breadcrumb = fn () => $breadcrumb;

        /** @var MockInterface|Request */
        $request = $this->partialMock(Request::class)
            ->shouldReceive('route')
            ->andReturn($route)
            ->getMock();

        $component = new Breadcrumb($request);

        $this->assertEquals($breadcrumb->toArray(), $component->breadcrumb);
    }

    public function test_it_should_get_the_breadcrumb_from_session()
    {
        $data = [
            ['label' => 'Test', 'url' => 'http://test.com'],
            ['label' => 'Test 2', 'url' => 'http://test2.com'],
        ];

        session()->put(Breadcrumb::SESSION_KEY, $data);

        /** @var Breadcrumb $component */
        $component = resolve(Breadcrumb::class);

        $this->assertSame($data, $component->breadcrumb);
    }

    public function test_it_should_make_the_page_title()
    {
        $route = $this->partialMock(Route::class)
            ->shouldReceive('getName')
            ->andReturn('test.index')
            ->getMock();

        /** @var MockInterface|Request */
        $request = $this->partialMock(Request::class)
            ->shouldReceive('route')
            ->andReturn($route)
            ->getMock();

        $component = new Breadcrumb($request);

        $this->assertEquals('Test Index', $component->page);
    }

    /** @dataProvider homeRouteProvider */
    public function test_it_should_set_and_render_the_home_route($route)
    {
        config()->set('wireui.breadcrumb.home', $route);

        $html = Blade::render('<x-breadcrumb />');

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
