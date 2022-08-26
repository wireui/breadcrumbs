<?php

namespace WireUi\Breadcrumbs;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    public const EVENT = 'wireui::breadcrumbs';

    public array $breadcrumbs = [];

    public ?string $page = null;

    public string $home = '';

    public function __construct(Request $request)
    {
        $route = $request->route();

        if ($route instanceof Route && property_exists($route, 'breadcrumbs')) {
            $this->breadcrumbs = $route->getBreadcrumbs();
        }

        if ($breadcrumbs = session()->pull(self::EVENT)) {
            $this->breadcrumbs = $breadcrumbs;
        }

        $this->page = $this->makePageName($request);

        $this->home = value(config('wireui.breadcrumbs.home'));
    }

    private function makePageName(Request $request): string
    {
        return Str::of($request->route()?->getName())
            ->replace('.', ' ')
            ->title()
            ->toString();
    }

    public function render(): View
    {
        return view('wireui.breadcrumbs::breadcrumbs');
    }
}
