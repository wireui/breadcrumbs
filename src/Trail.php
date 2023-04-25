<?php

namespace WireUi\Breadcrumbs;

class Trail
{
    /** @var array<int, Path> */
    protected array $paths = [];

    public static function make(): self
    {
        return new self();
    }

    public function push(string $label, ?string $url = null): self
    {
        $this->paths[] = new Path($label, $url);

        return $this;
    }

    /** @return array<int, Path> */
    public function toPaths(): array
    {
        return $this->paths;
    }

    public function toArray(): array
    {
        return array_map(
            fn (Path $path) => $path->toArray(),
            $this->paths,
        );
    }
}
