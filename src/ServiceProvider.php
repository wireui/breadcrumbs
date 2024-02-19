<?php

namespace WireUi\Breadcrumbs;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\{Component, ImplicitlyBoundMethod};
use WireUi\Breadcrumbs\Components\Tallstack;
use WireUi\Breadcrumbs\Http\Middleware\BreadcrumbsInjector;

use function Livewire\on as LivewireHook;

class ServiceProvider extends Support\ServiceProvider
{
    public function boot(): void
    {
        $this->registerConfig();

        if (config('wireui.breadcrumbs.alias')) {
            $this->registerComponent();
        }

        if (config('wireui.breadcrumbs.livewire.listeners')) {
            $this->registerLivewireListeners();
        }

        $this->app->singleton(Contracts\Repository::class, Repository::class);
        app(Kernel::class)->pushMiddleware(BreadcrumbsInjector::class);
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
        $this->publishes(
            ["{$rootDir}/../stubs/breadcrumbs.php.stub" => base_path('routes') . '/breadcrumbs.php'],
            'wireui.breadcrumbs.route',
        );
    }

    protected function registerComponent(): void
    {
        $this->callAfterResolving(BladeCompiler::class, static function (BladeCompiler $blade): void {
            /** @var string $alias */
            $alias = config('wireui.breadcrumbs.alias');
            $blade->component(Tallstack::class, $alias);
        });
    }

    private function registerLivewireListeners(): void
    {
        LivewireHook('mount', function (Component $component) {
            if (method_exists($component, 'breadcrumbs')) {
                $trail = ImplicitlyBoundMethod::call(app(), [$component, 'breadcrumbs']);

                if (!$trail instanceof Trail) {
                    return;
                }

                session()->now(Tallstack::EVENT, $trail->toArray());
            }
        });

        LivewireHook('hydrate', function (Component $component) {
            if (method_exists($component, 'breadcrumbs')) {
                $trail = ImplicitlyBoundMethod::call(app(), [$component, 'breadcrumbs']);

                if (!$trail instanceof Trail) {
                    return;
                }

                $component->dispatch(Tallstack::EVENT, $trail->toArray());
            }
        });
    }
}
