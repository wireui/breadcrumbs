<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use WireUi\Breadcrumbs\Trail;

it('should get the route breadcrumbs', function () {
    Route::get('test', function (Request $request) {
        return $request->route()->getBreadcrumbs();
    })->breadcrumbs(function (Trail $trail) {
        return $trail
            ->push('Test', 'http://test.com')
            ->push('Test 2', 'http://test2.com');
    });

    /** @var TestCase $this */
    $this->getJson('test')->assertExactJson([
        ['label' => 'Test', 'url' => 'http://test.com'],
        ['label' => 'Test 2', 'url' => 'http://test2.com'],
    ]);
});

it('should get a empty breadcrumbs if the route doesnt have breadcrumbs', function () {
    Route::get('test', function (Request $request) {
        return $request->route()->getBreadcrumbs();
    });

    /** @var TestCase $this */
    $this->getJson('test')->assertExactJson([]);
});
