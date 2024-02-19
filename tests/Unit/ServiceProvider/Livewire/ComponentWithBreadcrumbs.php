<?php

namespace Tests\Unit\ServiceProvider\Livewire;

use Livewire\Component;
use WireUi\Breadcrumbs\Trail;

class ComponentWithBreadcrumbs extends Component
{
    public function breadcrumbs(): Trail
    {
        return Trail::make()
            ->push('Home', '/')
            ->push('About', '/about');
    }

    public function render(): string
    {
        return '<div>Test Component</div>';
    }
}
