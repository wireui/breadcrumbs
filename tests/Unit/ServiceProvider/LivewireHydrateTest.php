<?php

use Livewire\Livewire;
use Tests\Unit\ServiceProvider\Livewire\{ComponentWithBreadcrumbs, ComponentWithInvalidBreadcrumbsType};
use WireUi\Breadcrumbs\Components\Tallstack;

it('should push the breadcrumbs to session in the initial request', function () {
    Livewire::test(ComponentWithBreadcrumbs::class)->assertSessionHas(Tallstack::EVENT, [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'About', 'url' => '/about'],
    ]);
});

it('should push to the events queue on subsequents request', function () {
    Livewire::test(ComponentWithBreadcrumbs::class)
        ->call('$refresh')
        ->assertDispatched(Tallstack::EVENT, [
            ['label' => 'Home',  'url' => '/'],
            ['label' => 'About', 'url' => '/about'],
        ]);
});

it('should not push the breadcrumbs to session in the initial request', function () {
    Livewire::test(ComponentWithInvalidBreadcrumbsType::class)->assertSessionMissing(Tallstack::EVENT);
});

it('should not push to the events queue on subsequents request', function () {
    Livewire::test(ComponentWithInvalidBreadcrumbsType::class)
        ->call('$refresh')
        ->assertNotDispatched(Tallstack::EVENT);
});
