<?php

use WireUi\Breadcrumbs\{Breadcrumbs, Trail};

Breadcrumbs::for('two')
    ->push('Two', 'two.com')
    ->push('View')
    ->callback(function (Trail $trail): Trail {
        return $trail->push('Final');
    });
