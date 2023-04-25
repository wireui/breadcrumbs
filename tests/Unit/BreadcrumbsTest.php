<?php

use Illuminate\Http\Request;
use WireUi\Breadcrumbs\Contracts\Repository;
use WireUi\Breadcrumbs\Exceptions\InvalidTrailInstance;
use WireUi\Breadcrumbs\{Breadcrumbs, Trail};

it('should get the breadcrumbs trail', function () {
    $breadcrumbs = Breadcrumbs::for('users')
        ->push('Users', 'my-route.com')
        ->push('View')
        ->callback(function (Trail $trail, Request $request): Trail {
            return $trail->push('Final');
        });

    $instance = app(Repository::class)->get('users');

    expect($instance)->toBe($breadcrumbs);

    $trail = $instance->toTrail();

    expect($trail)->toBeInstanceOf(Trail::class);

    expect($trail->toArray())->toBe([
        [
            'label' => 'Users',
            'url'   => 'my-route.com',
        ],
        [
            'label' => 'View',
            'url'   => null,
        ],
        [
            'label' => 'Final',
            'url'   => null,
        ],
    ]);

    expect($this->invadeProperty($instance, 'callback'))->toBeNull();
});

it('should throw an exception when the closure not returns a trail instance', function () {
    $this->expectException(InvalidTrailInstance::class);

    Breadcrumbs::for('users')
        ->push('Users', 'my-route.com')
        ->push('View')
        ->callback(fn () => 'not a trail instance');

    $instance = app(Repository::class)->get('users');

    $instance->toTrail();
});
