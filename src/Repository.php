<?php

namespace WireUi\Breadcrumbs;

final class Repository implements Contracts\Repository
{
    /** @var array<string, Breadcrumbs> */
    private array $breadcrumbs = [];

    public function set(string $name, Breadcrumbs $breadcrumbs): void
    {
        $this->breadcrumbs[$name] = $breadcrumbs;
    }

    public function get(string $name): ?Breadcrumbs
    {
        return $this->breadcrumbs[$name] ?? null;
    }

    public function all(): array
    {
        return $this->breadcrumbs;
    }
}
