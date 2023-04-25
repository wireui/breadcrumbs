<?php

namespace WireUi\Breadcrumbs\Contracts;

use Closure;
use WireUi\Breadcrumbs\Trail;

interface Breadcrumbs
{
    public static function for(string $route): self;

    public function push(string $label, ?string $url = null): self;

    public function callback(Closure $callback): self;

    public function toTrail(): Trail;
}
