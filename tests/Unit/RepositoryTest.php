<?php

use WireUi\Breadcrumbs\Contracts\Repository as RepositoryContract;
use WireUi\Breadcrumbs\{Breadcrumbs, Repository};

it('should set a breadcrumbs key/value', function () {
    $repository = new Repository();

    $repository->set('users', new Breadcrumbs());

    expect($repository->get('users'))->toBeInstanceOf(Breadcrumbs::class);
});

it('should return null when key is not found', function () {
    $repository = new Repository();

    expect($repository->get('users'))->toBeNull();
});

it('should return breadcrumbs by key', function () {
    $repository = new Repository();

    $repository->set('users', new Breadcrumbs());

    expect($repository->all())->toHaveCount(1);
});

it('should return all breadcrumbs', function () {
    $repository = new Repository();

    $repository->set('users', new Breadcrumbs());
    $repository->set('customers', new Breadcrumbs());

    expect($repository->all())->toHaveCount(2)
        ->and($repository->get('users'))->toBeInstanceOf(Breadcrumbs::class)
        ->and($repository->get('customers'))->toBeInstanceOf(Breadcrumbs::class)
        ->and($repository->all())->toHaveKeys(['users', 'customers']);
});

// it should be loaded as singleton and return the same instance
it('should bind the Repository contract with the Repository class', function () {
    $repository = app(RepositoryContract::class);

    $repository->set('users', new Breadcrumbs());

    $newInstance = app(RepositoryContract::class);

    expect($newInstance)->toBe($repository)
        ->and($newInstance->get('users'))->toBeInstanceOf(Breadcrumbs::class);
});
