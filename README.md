<p align="center">
    <a href="https://github.com/wireui/breadcrumbs/">
        <img src="https://img.shields.io/packagist/dt/wireui/breadcrumbs" alt="Packagist Downloads" data-canonical-src="https://img.shields.io/packagist/dt/wireui/breadcrumbs" style="max-width:100%;" />
    </a>
    <a href="https://github.com/wireui/breadcrumbs/blob/main/LICENSE">
        <img src="https://img.shields.io/github/license/wireui/breadcrumbs" alt="GitHub license" data-canonical-src="https://img.shields.io/github/license/wireui/breadcrumbs" style="max-width:100%;" />
    </a>
    <a href="https://twitter.com/ph7jack">
        <img alt="Twitter" src="https://img.shields.io/twitter/url?url=https%3A%2F%2Fgithub.com%2FPH7-Jack%2Fwireui">
    </a>
</p>

# WireUi Breadcrumbs

[![WireUi Breadcrumbs Tests](https://github.com/wireui/breadcrumbs/actions/workflows/test.yml/badge.svg)](https://github.com/wireui/breadcrumbs/actions/workflows/test.yml)

### 🔥 Breadcrumbs
**WireUI Breadcrumbs** package streamlines the process of implementing 
breadcrumbs in your **web application.** 
Our package offers an **elegant** and **customizable** breadcrumbs API 
that can be easily defined in your routes or full page livewire components. 

Simplify your users' navigation **experience** with our **intuitive** interface and straightforward code.


### 📚 Get Started
#### Prerequisites:
* [Laravel 10.x](https://laravel.com)
* [PHP 8.2](https://www.php.net/releases/8.1/en.php)
* [Livewire 2.10](https://laravel-livewire.com)

#### Optional - TallStack
If do you want to use the default breadcrumbs component, you need to install these packages.
* [Alpine.js 3.10](https://alpinejs.dev)
* [Tailwind 3.1](https://tailwindcss.com/docs/installation)

**Preview:**

<img  src="images/breadcrumb.png" alt="WireUi Breadcrumbs"/>

### 🚀 Installation
```bash
composer require wireui/breadcrumbs
```

#### Create the breadcrumbs route file
Run the following command to create the breadcrumbs route file.
```bash
php artisan vendor:publish --tag="wireui.breadcrumbs.route"
```

#### Using Tailwind?
Add the breadcrumbs path to the content of your Tailwind config file.
```js
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/wireui/breadcrumbs/src/Components/**/*.php',
        './vendor/wireui/breadcrumbs/src/views/**/*.blade.php',
    ],
}
```

### How to use?

#### Defining Route Breadcrumbs
You can create multiple breadcrumbs files to register your breadcrumbs.

- `routes/breadcrumbs.php` - Default
- `routes/breadcrumbs/users.php`
- `routes/breadcrumbs/customers.php`

Then, register these files in the breadcrumbs config file. See the [Publish section](#-publishing-optional).

```php
Breadcrumbs::for('users.view')
    ->push('Users', route('users'))
    ->push('View');
```

#### Livewire Components
You can define your breadcrumbs in the full page [Livewire Components](https://laravel-livewire.com/docs/2.x/rendering-components#page-components).
<br>The breadcrumbs in the livewire components is reactive
```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Breadcrumbs\Trail;

class Index extends Component
{
    /*
     * Don't forget
     *  - This method must return a `Trail` instance
     *  - It must be a public method
     *  - You can use dependency injection
     */
    public function breadcrumbs(Trail $trail): Trail
    {
        return $trail
            ->push('Users', route('users'))
            ->push('Create 1');
    }
}
```

#### Dependency Injection
When registering a route breadcrumb, you can use dependency injection.
It is useful when you need to get the current model in the route breadcrumb, or any other dependency.

```php
// route: /users/{user}
Breadcrumbs::for('users.view')
    ->push('Users', route('users'))
    ->push('View')
    ->callback(function (Trail $trail, User $user, Request $request): Trail {
        return $trail->push($user->name);
    });

// route: /posts/{id}
Breadcrumbs::for('posts.view')
    ->push('Users', route('users'))
    ->push('View')
    ->callback(function (Trail $trail, int $id): Trail {
        return $trail->push($id);
    });
```

#### Rendering (TallStack Only)
Just add the breadcrumbs component in your layout
```html
<x-breadcrumbs />
```
Support to others frameworks is coming soon.
- [ ] Bootstrap
- [ ] Bulma

### 📦 Publishing (Optional)
```bash
php artisan vendor:publish --tag="wireui.breadcrumbs.config"
php artisan vendor:publish --tag="wireui.breadcrumbs.views"
php artisan vendor:publish --tag="wireui.breadcrumbs.route"
```

### 📣 Follow the author
Get the latest news, updates, and insights on WireUI by following [@ph7jack] on Twitter.
As the creator of this package, [Pedro Oliveira] shares valuable 
information about features, ideas, and community discussions. 


### 💡 Philosophy
WireUI offers a collection of components that are essential for building 
web page applications, and it's completely free for anyone to use.

Created by [PH7-Jack] and maintained with community support, 
WireUI is an innovative project that welcomes contributions from developers 
of all backgrounds. 
Whether you're a seasoned professional or just starting, your input is valuable and appreciated.

Join the WireUI community today and take your web page app development to the next level!

### 📝 License
[MIT](https://opensource.org/licenses/MIT)


[Pedro Oliveira]: <https://www.linkedin.com/in/pedroliveira-dev>
[PH7-Jack]: <https://github.com/PH7-Jack>
[@ph7jack]: <https://twitter.com/ph7jack>
