<?php

use WireUi\Breadcrumbs\{Breadcrumbs, Trail};

Breadcrumbs::for('one')
    ->push('One', 'one.com')
    ->push('View')
    ->callback(function (Trail $trail): Trail {
        return $trail->push('Final');
    });
