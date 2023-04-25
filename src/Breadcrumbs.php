<?php

namespace WireUi\Breadcrumbs;

use Closure;
use Livewire\ImplicitlyBoundMethod;
use ReflectionException;
use WireUi\Breadcrumbs\Exceptions\InvalidTrailInstance;

final class Breadcrumbs implements Contracts\Breadcrumbs
{
    private Trail $trail;

    private ?Closure $callback = null;

    public static function for(string $route): self
    {
        $instance = new self();

        $instance->trail = new Trail();

        app(Contracts\Repository::class)->set($route, $instance);

        return $instance;
    }

    public function push(string $label, ?string $url = null): self
    {
        $this->trail->push($label, $url);

        return $this;
    }

    public function callback(Closure $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function toTrail(): Trail
    {
        $this->mergeCallbackIntoTrail();

        return $this->trail;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidTrailInstance
     */
    private function mergeCallbackIntoTrail(): void
    {
        if (!$this->callback) {
            return;
        }

        $routeParameters = request()->route()?->parameters() ?? [];

        $trail = ImplicitlyBoundMethod::call(app(), $this->callback, $routeParameters);

        if (!$trail instanceof Trail) {
            throw new InvalidTrailInstance();
        }

        foreach ($trail->toPaths() as $path) {
            $this->trail->push($path->label, $path->url);
        }

        $this->callback = null;
    }
}
