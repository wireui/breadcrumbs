<?php

namespace WireUi\Breadcrumbs\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class BreadcrumbsInjector
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        foreach (Arr::wrap(config('wireui.breadcrumbs.paths')) as $path) {
            require realpath($path) ?: base_path($path);
        }

        return $next($request);
    }
}
