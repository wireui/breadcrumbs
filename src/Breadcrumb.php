<?php

namespace WireUi\Breadcrumb;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $breadcrumb = [];

    public ?string $page = null;

    public string $home = '';

    public function __construct(Request $request)
    {
        $route = $request->route();

        if ($route instanceof Route && property_exists($route, 'breadcrumb')) {
            $this->breadcrumb = $route->getBreadcrumb();
        }

        if ($breadcrumb = session()->pull('wireui::breadcrumb')) {
            $this->breadcrumb = $breadcrumb;
        }

        $this->page = $this->getPageName();

        $this->home = value(config('wireui.breadcrumb.home'));
    }

    private function getPageName(): string
    {
        return Str::of(request()->route()->getName())
            ->replace('.', ' ')
            ->title()
            ->toString();
    }

    public function render(): View
    {
        return view('wireui.breadcrumb::breadcrumb');
    }
}
