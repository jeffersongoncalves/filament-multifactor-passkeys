<div class="filament-hidden">

![Filament Multifactor Passkeys](https://raw.githubusercontent.com/jeffersongoncalves/filament-multifactor-passkeys/2.x/art/jeffersongoncalves-filament-multifactor-passkeys.png)

</div>

# Filament Multifactor Passkeys

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-multifactor-passkeys.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-multifactor-passkeys)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-multifactor-passkeys/fix-php-code-style-issues.yml?branch=2.x&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/filament-multifactor-passkeys/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3A2.x)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-multifactor-passkeys.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-multifactor-passkeys)
[![License](https://img.shields.io/github/license/jeffersongoncalves/filament-multifactor-passkeys.svg?style=flat-square)](LICENSE.md)

Multi-factor authentication for Filament panels using WebAuthn passkeys, powered by [`spatie/laravel-passkeys`](https://spatie.be/docs/laravel-passkeys).

## Compatibility

| Branch | Filament | Laravel        | PHP    | Tag format |
|--------|----------|----------------|--------|------------|
| `1.x`  | v4       | 11 / 12        | ^8.2   | `1.x.y`    |
| `2.x`  | v5       | 12 / 13        | ^8.2   | `2.x.y`    |

## Installation

Install the package via composer:

```bash
composer require jeffersongoncalves/filament-multifactor-passkeys
```

Publish and run the migrations from `spatie/laravel-passkeys`:

```bash
php artisan vendor:publish --tag="passkeys-migrations"
php artisan migrate
```

Publish the `spatie/laravel-passkeys` config (optional, to tweak relying party, allowed origins, etc.):

```bash
php artisan vendor:publish --tag="passkeys-config"
```

Publish this package's config (optional):

```bash
php artisan vendor:publish --tag="filament-multifactor-passkeys-config"
```

## Usage

### 1. Prepare your User model

Add the Spatie `InteractsWithPasskeys` trait and implement the package's `HasPasskeyAuthentication` contract (which extends Spatie's `HasPasskeys` interface):

```php
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Contracts\HasPasskeyAuthentication;
use Spatie\LaravelPasskeys\Models\Concerns\InteractsWithPasskeys;

class User extends Authenticatable implements FilamentUser, HasPasskeyAuthentication
{
    use InteractsWithPasskeys;

    public function hasPasskeyAuthentication(): bool
    {
        return $this->passkeys()->exists();
    }

    // ...
}
```

### 2. Register the MFA provider in your panel

In your `PanelProvider`, register `PasskeyAuthentication` in the `multiFactorAuthentication()` array. To also expose a "Sign in with a passkey" button on the login screen, register the plugin as well:

```php
use Filament\Panel;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\MultiFactorPasskeysPlugin;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\PasskeyAuthentication;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->multiFactorAuthentication([
            PasskeyAuthentication::make(),
        ])
        ->plugin(MultiFactorPasskeysPlugin::make());
}
```

That's it. The MFA section in the user profile page now shows a "Passkey verification" entry with **Set up** / **Turn off** buttons. The plugin also injects a passkey login button after the standard login form, allowing users to authenticate without typing email/password. After registering a passkey, the next login can use it directly.

> The package auto-registers Spatie's `Route::passkeys()` macro (under the `web` middleware group) so the login button works out of the box. If you've already registered them yourself, the auto-registration is skipped.

### 3. Customising the redirect URL

By default, after a successful registration or assertion the user is redirected to the current panel home (`Filament::getCurrentPanel()->getUrl()`). To override:

```php
PasskeyAuthentication::make()
    ->redirectUrlUsing(fn () => route('dashboard'));
```

You can also set a static URL via `config/filament-multifactor-passkeys.php`:

```php
return [
    'redirect' => '/dashboard',
];
```

## How it works

This package is a thin Filament adapter on top of `spatie/laravel-passkeys`. The WebAuthn ceremony (challenge generation, browser API, attestation/assertion verification, persistence) is fully handled by Spatie's package and its Blade components (`<x-create-passkey>` and `<x-authenticate-passkey>`), which are embedded inside Filament modals and the MFA challenge schema.

- **Set up** opens a Filament modal that renders `<x-create-passkey :redirect="..." />`
- **Disable** removes all of the user's passkeys via `$user->passkeys()->delete()`
- **Login challenge** renders `<x-authenticate-passkey :redirect="..." />`

## Development

```bash
# Static analysis
composer analyse

# Code style
composer format

# Tests
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [Spatie](https://github.com/spatie/laravel-passkeys) — for the underlying WebAuthn implementation
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
