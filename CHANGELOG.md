# Changelog

All notable changes to `filament-multifactor-passkeys` will be documented in this file.

## 2.0.0 - 2026-05-04

### Filament Multifactor Passkeys 2.0.0 — Filament v5

First public release of the Filament v5 line, tracking the 2.x branch.

#### Highlights

- Multi-factor authentication for Filament panels using **WebAuthn passkeys**, powered by [`spatie/laravel-passkeys`](https://spatie.be/docs/laravel-passkeys).
- New `PasskeyAuthentication` MFA provider — registers under `->multiFactorAuthentication([...])` and adds a **Passkey verification** entry (Set up / Turn off) to the user profile page.
- `MultiFactorPasskeysPlugin` injects a **Sign in with a passkey** button on the login screen via a Livewire `AuthenticatePasskey` component (state persisted on a Locked Livewire property).
- Auto-registers Spatie's `Route::passkeys()` macro under the `web` middleware group when not already declared.
- Sends a Filament notification on successful passkey login.
- Configurable post-auth redirect via `redirectUrlUsing(...)` or `config/filament-multifactor-passkeys.php`.
- Compiled assets are minified by default.
- `esbuild` dev dependency pinned to `^0.25.0` (clears GHSA-67mh-4wv8-2f99).

#### Compatibility

- PHP `^8.2`
- Laravel 12 / 13
- Livewire v3
- Filament v5 (`^5.3`)

#### Install

```bash
composer require jeffersongoncalves/filament-multifactor-passkeys:^2.0

```