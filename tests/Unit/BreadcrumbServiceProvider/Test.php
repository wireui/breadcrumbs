<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\{Factory, FileViewFinder};

it('should register the views path', function () {
    /** @var Factory $view */
    $view = View::getFacadeRoot();

    /** @var FileViewFinder $finder */
    $finder = $view->getFinder();
    expect($finder->getHints())->toHaveKey('wireui.breadcrumb');
    expect($finder->getHints()['wireui.breadcrumb'][0])->toContain('src/views');
});

it('should merge the wireui.breadcrumb config', function () {
    expect(config('wireui.breadcrumb'))->toHaveKeys([
        'alias',
        'home',
    ]);
});

it('should add the publish groups', function () {
    $publishGroups = ServiceProvider::$publishGroups;

    expect($publishGroups)->toHaveKeys([
        'wireui.breadcrumb.config',
        'wireui.breadcrumb.views',
    ]);

    expect($publishGroups['wireui.breadcrumb.config'])->toBeArray()->toHaveCount(1);
    expect($publishGroups['wireui.breadcrumb.views'])->toBeArray()->toHaveCount(1);

    expect(array_key_first($publishGroups['wireui.breadcrumb.config']))->toBeFile();
    expect(array_key_first($publishGroups['wireui.breadcrumb.views']))->toBeDirectory();

    expect(array_values($publishGroups['wireui.breadcrumb.config'])[0])->toEndWith('config/wireui/breadcrumb.php');
    expect(array_values($publishGroups['wireui.breadcrumb.views'])[0])->toEndWith('resources/views/vendor/wireui/breadcrumb');
});

it('should register the blade components', function () {
    /** @var BladeCompiler $bladeCompiler */
    $bladeCompiler = resolve(BladeCompiler::class);

    expect($bladeCompiler->getClassComponentAliases())->toHaveKey('breadcrumb');
});
