<?php

namespace WireUi\Breadcrumbs;

use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\{Component, ImplicitlyBoundMethod, Livewire};

class BreadcrumbsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerComponent();
        $this->registerRouteMacros();
        $this->registerLivewireListeners();
    }

    protected function registerConfig(): void
    {
        $rootDir = __DIR__;

        $this->mergeConfigFrom("{$rootDir}/config.php", 'wireui.breadcrumbs');
        $this->loadViewsFrom("{$rootDir}/views", 'wireui');

        $this->publishes(
            ["{$rootDir}/config.php" => config_path('wireui/breadcrumbs.php')],
            'wireui.breadcrumbs.config',
        );
        $this->publishes(
            ["{$rootDir}/views" => resource_path('views/vendor/wireui')],
            'wireui.breadcrumbs.views',
        );
    }

    protected function registerComponent(): void
    {
        if (!config('wireui.breadcrumbs.alias')) {
            return;
        }

        $this->callAfterResolving(BladeCompiler::class, static function (BladeCompiler $blade): void {
            /** @var string $alias */
            $alias = config('wireui.breadcrumbs.alias');
            $blade->component(Breadcrumbs::class, $alias);
        });
    }

    protected function registerRouteMacros(): void
    {
        Route::macro('breadcrumbs', function (callable $callback): Route {
            /** @var Route $this */
            $this->breadcrumbs = function () use ($callback) {
                $route = request()->route();

                return ImplicitlyBoundMethod::call(app(), $callback, $route->parameters());
            };

            return $this;
        });

        Route::macro('getBreadcrumbs', function (): array {
            /** @var Route $this */
            if (property_exists($this, 'breadcrumbs')) {
                return ($this->breadcrumbs)()->toArray();
            }

            return [];
        });
    }

    private function registerLivewireListeners(): void
    {
        Livewire::listen('component.hydrate.initial', function (Component $component) {
            if (method_exists($component, 'breadcrumbs')) {
                /** @var Trail $breadcrumbs */
                $breadcrumbs = ImplicitlyBoundMethod::call(app(), [$component, 'breadcrumbs']);

                session()->flash(Breadcrumbs::EVENT, $breadcrumbs->toArray());
            }
        });

        Livewire::listen('component.hydrate', static function (Component $component): void {
            if (method_exists($component, 'breadcrumbs')) {
                /** @var Trail $breadcrumbs */
                $breadcrumbs = ImplicitlyBoundMethod::call(app(), [$component, 'breadcrumbs']);

                $component->dispatchBrowserEvent(Breadcrumbs::EVENT, $breadcrumbs->toArray());
            }
        });
    }
}
