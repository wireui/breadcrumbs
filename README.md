<p align="center">
    <a href="https://github.com/wireui/breadcrumbs/">
        <img src="https://img.shields.io/packagist/dt/wireui/breadcrumbs" alt="Packagist Downloads" data-canonical-src="https://img.shields.io/packagist/dt/wireui/breadcrumbs" style="max-width:100%;" />
    </a>
    <a href="https://github.com/wireui/breadcrumbs/blob/main/LICENSE">
        <img src="https://img.shields.io/github/license/wireui/breadcrumbs" alt="GitHub license" data-canonical-src="https://img.shields.io/github/license/wireui/breadcrumbs" style="max-width:100%;" />
    </a>
    <a href="https://twitter.com/ph7jack">
        <img alt="Twitter" src="https://img.shields.io/twitter/url?url=https%3A%2F%2Fgithub.com%2FPH7-Jack%2Fwireui"></a>
    </a>
</p>

# WireUi Breadcrumbs

[![WireUi Breadcrumbs Tests](https://github.com/wireui/breadcrumbs/actions/workflows/test.yml/badge.svg)](https://github.com/wireui/breadcrumbs/actions/workflows/test.yml)

### 🔥 Breadcrumbs
This package provides a beautiful **breadcrumbs** component, with a simple and easy way to use define your breadcrumbs.
<br>You can define your breadcrumbs in the **routes** or **livewire** components.

<img  src="images/breadcrumb.png" alt="WireUi Breadcrumbs"/>

### 📚 Get Started
#### Prerequisites:
* [Laravel 9.x](https://laravel.com)
* [PHP 8.1](https://www.php.net/releases/8.1/en.php)
* [Livewire 2.10](https://laravel-livewire.com)

#### Optional
If you want to use the default breadcrumbs component, you need to install these packages.
* [Alpine.js 3.10](https://alpinejs.dev)
* [Tailwind 3.1](https://tailwindcss.com/docs/installation)

#### Install
```bash
composer require wireui/breadcrumbs
```

#### Using Tailwind?
Add the breadcrumbs path to the content of your Tailwind config file.
```js
/** @type {import('tailwindcss').Config} */
module.exports = {
    ...
    content: [
        './vendor/wireui/breadcrumbs/src/**/*.php',
    ],
    ...
}
```

#### How to use it?
You can define the routes by calling the breadcrumbs method in the route or the livewire component.
<br>This method accepts a callable function that returns the Trail instance.

#### Dependency Injection
The callable function can resolve all dependency injections, like classes, services, models, etc.
```php
use Illuminate\Support\Facades\Route;
use WireUi\Breadcrumbs\Trail;

Route::get('/users/{user}', Index::class)
    ->breadcrumbs(function (
        Trail $trail,
        User $user,
        Request $request,
        Foo $foo
    ) {
        return $trail
            ->push('Users', route('users'))
            ->push('View');
    })
    ->name('users.view');
```

#### Routes
You can define yours breadcrumbs in the routes
```php
use Illuminate\Support\Facades\Route;
use WireUi\Breadcrumbs\Trail;

Route::get('/users/create', Index::class)
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->push('Users', route('users'))
            ->push('Create');
    })
    ->name('users.create');
```

#### Livewire Components
You can define yours breadcrumbs in the livewire components.
<br>The breadcrumbs in the livewire components is reactive
```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Breadcrumbs\Trail;

class Index extends Component
{
    ...

    public function breadcrumbs(Trail $trail): Trail
    {
        return $trail
            ->push('Users', route('users'))
            ->push('Create 1');
    }

    ...
}
```

#### Rendering
Just add the breadcrumbs component in your layout
```html
<x-breadcrumbs />
```

#### Publish (Optional)
```bash
php artisan vendor:publish --tag="wireui.breadcrumbs.config"
php artisan vendor:publish --tag="wireui.breadcrumbs.views"
```

### 📣 Follow the author
Stay informed about WireUI, follow [@ph7jack] on Twitter.

You will you see all the latest news about features, ideas, discussions, and more...

### 💡 Philosophy
WireUI Breadcrumbs is always FREE to anyone who would like to use it.
You can use the Breadcrumbs in your laravel project.

This project is created [PH7-Jack], and it is maintained by the author with the help of the community.

All contributions are welcome!

### 📝 License
[MIT](https://opensource.org/licenses/MIT)


[PH7-Jack]: <https://github.com/PH7-Jack>
[@ph7jack]: <https://twitter.com/ph7jack>
