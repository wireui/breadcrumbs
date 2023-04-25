<?php

return [
    /*
    |-------------------------------------------------------------------------|
    | Component alias                                                         |
    |-------------------------------------------------------------------------|
    | The component alias to import in the blade/livewire component           |
    | Set as false to disable the component.                                  |
    |-------------------------------------------------------------------------|
    | Example                                                                 |
    | <x-breadcrumbs />                                                       |
    |-------------------------------------------------------------------------|
    */
    'alias' => 'breadcrumbs',

    /*
    |-------------------------------------------------------------------------|
    | Livewire Integration                                                    |
    |-------------------------------------------------------------------------|
    | If your project don't use Livewire, you can disable all livewire stuff. |
    |-------------------------------------------------------------------------|
    */
    'livewire' => [
        'listeners' => true,
    ],

    /*
    |-------------------------------------------------------------------------|
    | Home route                                                              |
    |-------------------------------------------------------------------------|
    | Define a home route to use as the first breadcrumb.                     |
    | You can pass a string value or a closure that returns a string value.   |
    |-------------------------------------------------------------------------|
    | Example                                                                 |
    | 'home' => '/home',                                                      |
    | 'home' => fn() => route('home'),                                        |
    |-------------------------------------------------------------------------|
    */
    'home' => '/',

    /*
    |-------------------------------------------------------------------------|
    | Breadcrumbs Paths                                                       |
    |-------------------------------------------------------------------------|
    | Define all breadcrumbs paths to load the trails.                        |
    | Usually it will be in one file, but you can create specific files       |
    | for your breadcrumbs.                                                   |
    | Keep in mind your project root folder will be used for all paths.       |                                                |
    |-------------------------------------------------------------------------|
    | Example                                                                 |
    | 'paths' => [                                                            |
    |      'routes/module.breadcrumbs.php',                                   |
    |      'routes/admin.breadcrumbs.php',                                    |
    | ]                                                                       |
    |-------------------------------------------------------------------------|
    */
    'paths' => [
        'routes/breadcrumbs.php',
    ],
];
