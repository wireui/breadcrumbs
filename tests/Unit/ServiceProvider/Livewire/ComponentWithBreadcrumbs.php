<?php

namespace Tests\Unit\ServiceProvider\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\{Component, CreateBladeView};
use WireUi\Breadcrumbs\Trail;

class ComponentWithBreadcrumbs extends Component
{
    public function breadcrumbs(): Trail
    {
        return Trail::make()
            ->push('Home', '/')
            ->push('About', '/about');
    }

    public function render(): View
    {
        return app('view')->make(
            CreateBladeView::fromString('<div>Test Component</div>'),
        );
    }
}
