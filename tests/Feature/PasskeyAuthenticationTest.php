<?php

use JeffersonGoncalves\Filament\MultiFactorPasskeys\PasskeyAuthentication;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Tests\Fixtures\User;

it('can create passkey authentication instance', function () {
    $auth = PasskeyAuthentication::make();

    expect($auth)->toBeInstanceOf(PasskeyAuthentication::class);
});

it('returns passkey as id', function () {
    $auth = PasskeyAuthentication::make();

    expect($auth->getId())->toBe('passkey');
});

it('returns login form label as translation', function () {
    $auth = PasskeyAuthentication::make();
    $label = $auth->getLoginFormLabel();

    expect($label)->toBeString();
});

it('returns challenge form components as array', function () {
    $user = new User([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $auth = PasskeyAuthentication::make();
    $components = $auth->getChallengeFormComponents($user);

    expect($components)
        ->toBeArray()
        ->not->toBeEmpty();
});

it('falls back to root url when panel is not available', function () {
    $auth = PasskeyAuthentication::make();

    expect($auth->getRedirectUrl())->toBeString();
});

it('uses custom redirect closure when provided', function () {
    $auth = PasskeyAuthentication::make()
        ->redirectUrlUsing(fn () => '/custom-url');

    expect($auth->getRedirectUrl())->toBe('/custom-url');
});

it('returns management schema components as array', function () {
    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $this->actingAs($user);

    $auth = PasskeyAuthentication::make();
    $components = $auth->getManagementSchemaComponents();

    expect($components)
        ->toBeArray()
        ->not->toBeEmpty();
});

it('returns actions as array', function () {
    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $this->actingAs($user);

    $auth = PasskeyAuthentication::make();
    $actions = $auth->getActions();

    expect($actions)
        ->toBeArray()
        ->not->toBeEmpty();
});

it('reports user as disabled when user has no passkeys', function () {
    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $auth = PasskeyAuthentication::make();

    expect($auth->isEnabled($user))->toBeFalse();
});
