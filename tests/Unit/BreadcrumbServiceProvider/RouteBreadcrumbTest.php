<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use WireUi\Breadcrumb\Trail;

it('should get the route breadcrumb', function () {
    Route::get('test', function (Request $request) {
        return $request->route()->getBreadcrumb();
    })->breadcrumb(function (Trail $trail) {
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

it('should get a empty breadcrumb if the route doesnt have breadcrumb', function () {
    Route::get('test', function (Request $request) {
        return $request->route()->getBreadcrumb();
    });

    /** @var TestCase $this */
    $this->getJson('test')->assertExactJson([]);
});
