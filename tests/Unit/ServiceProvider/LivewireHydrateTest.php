<?php

use Illuminate\Http\Request;
use Livewire\Livewire;
use Tests\Unit\ServiceProvider\{Livewire\ComponentWithBreadcrumbs, Livewire\ComponentWithInvalidBreadcrumbsType};
use WireUi\Breadcrumbs\Components\Tallstack;
use WireUi\Breadcrumbs\Exceptions\InvalidTrailInstance;

it('should push the breadcrumbs to session in the initial request', function () {
    Livewire::test(ComponentWithBreadcrumbs::class)->assertSessionHas(Tallstack::EVENT, [
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'About', 'url' => '/about'],
    ]);
});

it('should throw InvalidTrailInstance when the breadcrumbs method doesnt returns a Trail instance in component.hydrate.initial', function () {
    $this->expectException(InvalidTrailInstance::class);

    Livewire::dispatch('component.hydrate.initial', new ComponentWithInvalidBreadcrumbsType());
});

it('should throw InvalidTrailInstance when the breadcrumbs method doesnt returns a Trail instance in component.hydrate', function () {
    $this->expectException(InvalidTrailInstance::class);

    Livewire::dispatch(
        'component.hydrate',
        new ComponentWithInvalidBreadcrumbsType(),
        new Request(),
    );
});

it('should push to the events queue on subsequents request', function () {
    Livewire::test(ComponentWithBreadcrumbs::class)
        ->call('$refresh')
        ->assertDispatchedBrowserEvent(Tallstack::EVENT, [
            ['label' => 'Home',  'url' => '/'],
            ['label' => 'About', 'url' => '/about'],
        ]);
});
