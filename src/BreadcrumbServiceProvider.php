<?php

namespace WireUi\Breadcrumb;

use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\{Component, ImplicitlyBoundMethod, Livewire};

class BreadcrumbServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerBladeComponents();
        $this->registerRouteMacros();
        $this->registerLivewireListeners();
    }

    protected function registerConfig(): void
    {
        $rootDir = __DIR__;

        $this->loadViewsFrom("{$rootDir}/views", 'wireui.breadcrumb');
        $this->mergeConfigFrom("{$rootDir}/config.php", 'wireui.breadcrumb');
        $this->publishes(
            ["{$rootDir}/config.php" => config_path('wireui/breadcrumb.php')],
            'wireui.breadcrumb.config'
        );
        $this->publishes(
            ["{$rootDir}/views" => resource_path('views/vendor/wireui/breadcrumb')],
            'wireui.breadcrumb.views'
        );
    }

    protected function registerBladeComponents(): void
    {
        if (!config('wireui.breadcrumb.alias')) {
            return;
        }

        $this->callAfterResolving(BladeCompiler::class, static function (BladeCompiler $blade): void {
            /** @var string $alias */
            $alias = config('wireui.breadcrumb.alias');
            $blade->component(Breadcrumb::class, $alias);
        });
    }

    protected function registerRouteMacros(): void
    {
        Route::macro('breadcrumb', function (callable $callback): Route {
            /** @var Route $this */

            $this->breadcrumb = function () use ($callback) {
                $route = request()->route();

                return ImplicitlyBoundMethod::call(app(), $callback, $route->parameters());
            };

            return $this;
        });

        Route::macro('getBreadcrumb', function (): array {
            /** @var Route $this */

            if (property_exists($this, 'breadcrumb')) {
                return ($this->breadcrumb)()->toArray();
            }

            return [];
        });
    }

    private function registerLivewireListeners(): void
    {
        Livewire::listen('component.hydrate', static function (Component $component): void {
            if (method_exists($component, 'breadcrumb')) {
                /** @var Trail $breadcrumb */
                $breadcrumb = ImplicitlyBoundMethod::call(app(), [$component, 'breadcrumb']);

                $component->dispatchBrowserEvent('breadcrumb', $breadcrumb->toArray());
            }
        });
    }
}
