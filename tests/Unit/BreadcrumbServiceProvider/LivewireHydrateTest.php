<?php

use Illuminate\Contracts\View\View;
use Livewire\{Component, CreateBladeView, Livewire};
use WireUi\Breadcrumb\{Breadcrumb, Trail};

class ComponentWithBreadcrumb extends Component
{
    public function breadcrumb(): Trail
    {
        return (new Trail())
            ->push('Home', '/')
            ->push('About', '/about');
    }

    public function render(): View
    {
        return app('view')->make(
            CreateBladeView::fromString('<div>Test Component</div>')
        );
    }
}

it('should push the breadcrumb to session in the initial request', function () {
    Livewire::test(ComponentWithBreadcrumb::class)->assertSessionHas(Breadcrumb::SESSION_KEY, [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'About', 'url' => '/about'],
    ]);
});

it('should push to the events queue on subsequents request', function () {
    Livewire::test(ComponentWithBreadcrumb::class)
        ->call('$refresh')
        ->assertDispatchedBrowserEvent(Breadcrumb::SESSION_KEY, [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'About', 'url' => '/about'],
        ]);
});
