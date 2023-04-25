<?php

namespace WireUi\Breadcrumbs\Exceptions;

use Exception;
use WireUi\Breadcrumbs\Trail;

final class InvalidTrailInstance extends Exception
{
    public function __construct()
    {
        $message = 'The breadcrumbs() method must return an instance of '
            . Trail::class
            . ' or a subclass of it.';

        parent::__construct(message: $message);
    }
}
