<?php

namespace Tests\Unit\Components;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use WireUi\Breadcrumbs\Breadcrumbs;
use WireUi\Breadcrumbs\Components\Tallstack;

class TallstackTest extends TestCase
{
    public function test_it_should_get_the_breadcrumbs_from_route(): void
    {
        Breadcrumbs::for($routeName = 'test')
            ->push('Test', 'http://test.com')
            ->push('Test 2', 'http://test2.com');

        /** @var Route $route */
        $route = Mockery::mock(new Route(['GET'], 'test', fn () => ''))
            ->makePartial()
            ->shouldReceive('getName')
            ->andReturn($routeName)
            ->getMock();

        /** @var Request $request */
        $request = $this->partialMock(Request::class)
            ->shouldReceive('route')
            ->andReturn($route)
            ->getMock();

        $component = new Tallstack($request);

        $this->assertSame($component->breadcrumbs, [
            ['label' => 'Test',   'url' => 'http://test.com'],
            ['label' => 'Test 2', 'url' => 'http://test2.com'],
        ]);
    }

    public function test_it_should_return_an_empty_breadcrumbs_value_from_route_when_it_not_exists(): void
    {
        /** @var Route $route */
        $route = Mockery::mock(new Route(['GET'], 'test', fn () => ''))
            ->makePartial()
            ->shouldReceive('getName')
            ->andReturn('test')
            ->getMock();

        /** @var Request $request */
        $request = $this->partialMock(Request::class)
            ->shouldReceive('route')
            ->andReturn($route)
            ->getMock();

        $component = new Tallstack($request);

        $this->assertSame($component->breadcrumbs, []);
    }

    public function test_it_should_return_an_empty_breadcrumbs_from_route_when_exists_but_is_empty(): void
    {
        Breadcrumbs::for($routeName = 'test');

        /** @var Route $route */
        $route = Mockery::mock(new Route(['GET'], 'test', fn () => ''))
            ->makePartial()
            ->shouldReceive('getName')
            ->andReturn($routeName)
            ->getMock();

        /** @var Request $request */
        $request = $this->partialMock(Request::class)
            ->shouldReceive('route')
            ->andReturn($route)
            ->getMock();

        $component = new Tallstack($request);

        $this->assertSame($component->breadcrumbs, []);
    }

    public function test_it_should_get_the_breadcrumbs_from_session(): void
    {
        $data = [
            ['label' => 'Test', 'url' => 'http://test.com'],
            ['label' => 'Test 2', 'url' => 'http://test2.com'],
        ];

        session()->put(Tallstack::EVENT, $data);

        /** @var Tallstack $component */
        $component = resolve(Tallstack::class);

        $this->assertSame($data, $component->breadcrumbs);
    }

    #[DataProvider('homeRouteProvider')]
    public function test_it_should_set_and_render_the_home_route($route): void
    {
        config()->set('wireui.breadcrumbs.home', $route);

        $html = Blade::render('<x-breadcrumbs />');

        $this->assertStringContainsString('href="https://example.com"', $html);
    }

    public static function homeRouteProvider(): array
    {
        return [
            ['https://example.com'],
            [fn () => 'https://example.com'],
        ];
    }
}
