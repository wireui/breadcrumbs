<?php

namespace WireUi\Breadcrumbs;

class Trail
{
    private $breadcrumbs = [];

    public function push(string $label, ?string $url = null): self
    {
        $this->breadcrumbs[] = [
            'label' => $label,
            'url'   => $url,
        ];

        return $this;
    }

    public function toArray(): array
    {
        return $this->breadcrumbs;
    }
}
