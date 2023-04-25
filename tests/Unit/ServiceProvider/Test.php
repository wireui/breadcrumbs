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
    expect($finder->getHints())->toHaveKey('wireui');
    expect($finder->getHints()['wireui'][0])->toContain('src/views');
});

it('should merge the wireui.breadcrumbs config', function () {
    expect(config('wireui.breadcrumbs'))->toHaveKeys([
        'alias',
        'home',
    ]);
});

it('should add the publish groups', function () {
    $publishGroups = ServiceProvider::$publishGroups;

    expect($publishGroups)->toHaveKeys([
        'wireui.breadcrumbs.config',
        'wireui.breadcrumbs.views',
        'wireui.breadcrumbs.route',
    ]);

    expect($publishGroups['wireui.breadcrumbs.config'])->toBeArray()->toHaveCount(1);
    expect($publishGroups['wireui.breadcrumbs.views'])->toBeArray()->toHaveCount(1);
    expect($publishGroups['wireui.breadcrumbs.route'])->toBeArray()->toHaveCount(1);

    expect(array_key_first($publishGroups['wireui.breadcrumbs.config']))->toBeFile();
    expect(array_key_first($publishGroups['wireui.breadcrumbs.views']))->toBeDirectory();
    expect(array_key_first($publishGroups['wireui.breadcrumbs.route']))->toBeFile();

    expect(array_values($publishGroups['wireui.breadcrumbs.config'])[0])->toEndWith('config/wireui/breadcrumbs.php');
    expect(array_values($publishGroups['wireui.breadcrumbs.views'])[0])->toEndWith('resources/views/vendor/wireui');
    expect(array_values($publishGroups['wireui.breadcrumbs.route'])[0])->toEndWith('routes/breadcrumbs.php');
});

it('should register the blade components', function () {
    /** @var BladeCompiler $bladeCompiler */
    $bladeCompiler = resolve(BladeCompiler::class);

    expect($bladeCompiler->getClassComponentAliases())->toHaveKey('breadcrumbs');
});
