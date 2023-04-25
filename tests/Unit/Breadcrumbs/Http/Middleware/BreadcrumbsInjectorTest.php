<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use WireUi\Breadcrumbs\Contracts\Repository;
use WireUi\Breadcrumbs\Http\Middleware\BreadcrumbsInjector;

it('should register the breadcrumbs injector middleware as global middleware', function () {
    $kernel = app(Kernel::class);

    expect($kernel->hasMiddleware(BreadcrumbsInjector::class))->toBeTrue();
});

it('should require all breadcrumbs route files', function () {
    config()->set('wireui.breadcrumbs.paths', [
        __DIR__ . '/routes/one.php',
        __DIR__ . '/routes/two.php',
    ]);

    Route::get('/', fn () => 'Hello World!');

    $this->get('/')->assertSee('Hello World!');

    expect(app(Repository::class)->all())->toHaveCount(2);
});
