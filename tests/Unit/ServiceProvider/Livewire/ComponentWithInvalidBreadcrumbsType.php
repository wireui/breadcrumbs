<?php

namespace Tests\Unit\ServiceProvider\Livewire;

use Livewire\Component;

class ComponentWithInvalidBreadcrumbsType extends Component
{
    public function breadcrumbs(): array
    {
        return [];
    }

    public function render(): string
    {
        return '<div>Test Component</div>';
    }
}
