<?php

namespace WireUi\Breadcrumb;

class Trail
{
    private $breadcrumb = [];

    public function push(string $label, ?string $url = null): self
    {
        $this->breadcrumb[] = [
            'label' => $label,
            'url'   => $url,
        ];

        return $this;
    }

    public function toArray(): array
    {
        return $this->breadcrumb;
    }
}
