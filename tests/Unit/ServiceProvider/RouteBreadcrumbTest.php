<?php

use WireUi\Breadcrumbs\Breadcrumbs;
use WireUi\Breadcrumbs\Contracts\Repository;

it('should get the route breadcrumbs', function () {
    Breadcrumbs::for($route = 'test')
        ->push('Test', 'http://test.com')
        ->push('Test 2', 'http://test2.com');

    /** @var ?Breadcrumbs $breadcrumbs */
    $breadcrumbs = app(Repository::class)->get($route);

    expect($breadcrumbs)->toBeInstanceOf(Breadcrumbs::class)
        ->and($breadcrumbs->toTrail()->toArray())->toEqual([
            ['label' => 'Test', 'url' => 'http://test.com'],
            ['label' => 'Test 2', 'url' => 'http://test2.com'],
        ]);
});

it('should get a null breadcrumbs if the route doesnt have breadcrumbs', function () {
    /** @var ?Breadcrumbs $breadcrumbs */
    $breadcrumbs = app(Repository::class)->get('test');

    expect($breadcrumbs)->toBeNull();
});
