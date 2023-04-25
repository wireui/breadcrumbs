<?php

namespace WireUi\Breadcrumbs;

final readonly class Path
{
    public function __construct(
        public string $label,
        public ?string $url,
    ) {
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'url'   => $this->url,
        ];
    }
}
