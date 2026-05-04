<?php

it('publishes config file', function () {
    $config = config('filament-multifactor-passkeys');

    expect($config)
        ->toBeArray()
        ->toHaveKey('redirect');
});

it('has null as default redirect', function () {
    expect(config('filament-multifactor-passkeys.redirect'))->toBeNull();
});

it('loads translations', function () {
    $translation = __('filament-multifactor-passkeys::provider.login_form.label');

    expect($translation)
        ->toBeString()
        ->not->toBe('filament-multifactor-passkeys::provider.login_form.label');
});
