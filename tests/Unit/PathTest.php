<?php

use WireUi\Breadcrumbs\Path;

it('should instance and get a Path as array', function () {
    $path = new Path('Users', 'my-route.com');

    expect($path->toArray())->toBe([
        'label' => 'Users',
        'url'   => 'my-route.com',
    ]);
});
