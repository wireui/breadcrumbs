<?php

namespace Tests\Unit\ServiceProvider\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\{Component, CreateBladeView};

class ComponentWithInvalidBreadcrumbsType extends Component
{
    public function breadcrumbs(): array
    {
        return [];
    }

    public function render(): View
    {
        return app('view')->make(
            CreateBladeView::fromString('<div>Test Component</div>'),
        );
    }
}
