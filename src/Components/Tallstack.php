<?php

namespace WireUi\Breadcrumbs\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use WireUi\Breadcrumbs\Breadcrumbs;
use WireUi\Breadcrumbs\Contracts\Repository;

class Tallstack extends Component
{
    public const EVENT = 'wireui::breadcrumbs';

    public array $breadcrumbs = [];

    public string $home = '';

    public function __construct(Request $request)
    {
        if (session()->exists(self::EVENT)) {
            $this->breadcrumbs = Arr::wrap(session()->get(self::EVENT));
        }

        if (!$this->breadcrumbs) {
            $this->breadcrumbs = $this->getBreadcrumbsFromRequest($request);
        }

        /** @var string $home */
        $home = value(config('wireui.breadcrumbs.home'));

        $this->home = $home;
    }

    public function getBreadcrumbsFromRequest(Request $request): array
    {
        $route = $request->route()?->getName();

        if (!$route) {
            return [];
        }

        $breadcrumbs = app(Repository::class)->get($route);

        if ($breadcrumbs instanceof Breadcrumbs) {
            return $breadcrumbs->toTrail()->toArray();
        }

        return [];
    }

    public function render(): View
    {
        return view('wireui::tallstack');
    }
}
