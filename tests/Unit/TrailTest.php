<?php

use WireUi\Breadcrumbs\Trail;

it('should push breadcrumbs and get as array', function () {
    $trail = Trail::make()
        ->push('Users', 'my-route.com')
        ->push('View');

    expect($trail->toArray())->toBe([
        [
            'label' => 'Users',
            'url'   => 'my-route.com',
        ],
        [
            'label' => 'View',
            'url'   => null,
        ],
    ]);
});
