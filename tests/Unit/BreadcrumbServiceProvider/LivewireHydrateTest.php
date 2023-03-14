<?php

use Illuminate\Contracts\View\View;
use Livewire\{Component, CreateBladeView, Livewire};
use WireUi\Breadcrumbs\{Breadcrumbs, Trail};

class ComponentWithBreadcrumbs extends Component
{
    public function breadcrumbs(): Trail
    {
        return (new Trail())
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

it('should push the breadcrumbs to session in the initial request', function () {
    Livewire::test(ComponentWithBreadcrumbs::class)->assertSessionHas(Breadcrumbs::EVENT, [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'About', 'url' => '/about'],
    ]);
});

it('should push to the events queue on subsequents request', function () {
    Livewire::test(ComponentWithBreadcrumbs::class)
        ->call('$refresh')
        ->assertDispatchedBrowserEvent(Breadcrumbs::EVENT, [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'About', 'url' => '/about'],
        ]);
});
