<?php

namespace WireUi\Breadcrumbs\Contracts;

use WireUi\Breadcrumbs\Breadcrumbs;

interface Repository
{
    public function set(string $name, Breadcrumbs $breadcrumbs): void;

    public function get(string $name): ?Breadcrumbs;

    /** @return array<string, Breadcrumbs> */
    public function all(): array;
}
