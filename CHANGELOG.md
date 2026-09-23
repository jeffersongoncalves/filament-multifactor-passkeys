# Changelog

All notable changes to `filament-multifactor-passkeys` will be documented in this file.

## 1.1.0 - 2026-09-23

### What's new

- **Translations:** 5 new locales (az, fa, hi, pt, uz). (#15)

Thanks to @Elvin-Qulizade (Elvin Qulizada) for the i18n initiative behind these translations — first contributed in jeffersongoncalves/filament-scanner-guard#2 and now rolled out across the Filament plugins. He is credited as co-author.

### What's Changed

* ci: standardize update-changelog workflow (1.x) by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/7
* chore(deps): Bump actions/checkout from 6.1.0 to 7.0.1 in the actions-deps group by @dependabot[bot] in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/10
* chore(deps): Bump the npm-deps group with 2 updates by @dependabot[bot] in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/12
* ci: standardize tests workflow (1.x) by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/13
* feat(i18n): add translations (1.x) by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/15

**Full Changelog**: https://github.com/jeffersongoncalves/filament-multifactor-passkeys/compare/1.0.1...1.1.0

## 1.0.1 - 2026-08-17

Fix duplicate WebAuthn listener registration when `@script` is evaluated more than once for the same component, which caused the in-flight authentication/registration ceremony to be aborted. Ports the fix from #4 (2.x).

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