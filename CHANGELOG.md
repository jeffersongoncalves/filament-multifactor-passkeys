# Changelog

All notable changes to `filament-multifactor-passkeys` will be documented in this file.

## 1.0.0 - 2026-05-04

### Filament Multifactor Passkeys 1.0.0 — Filament v4

First public release of the Filament v4 line.

#### Highlights

- Multi-factor authentication for Filament panels using **WebAuthn passkeys**, powered by [`spatie/laravel-passkeys`](https://spatie.be/docs/laravel-passkeys).
- New `PasskeyAuthentication` MFA provider — registers under `->multiFactorAuthentication([...])` and adds a **Passkey verification** entry (Set up / Turn off) to the user profile page.
- `MultiFactorPasskeysPlugin` injects a **Sign in with a passkey** button on the login screen via a Livewire `AuthenticatePasskey` component (state persisted on a Locked Livewire property).
- Auto-registers Spatie's `Route::passkeys()` macro under the `web` middleware group when not already declared.
- Sends a Filament notification on successful passkey login.
- Configurable post-auth redirect via `redirectUrlUsing(...)` or `config/filament-multifactor-passkeys.php`.
- Compiled assets are minified by default.

#### Compatibility

- PHP `^8.2`
- Laravel 11 / 12
- Livewire v3
- Filament v4

#### Install

```bash
composer require jeffersongoncalves/filament-multifactor-passkeys:^1.0

```