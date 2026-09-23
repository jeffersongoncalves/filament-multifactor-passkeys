# Changelog

All notable changes to `filament-multifactor-passkeys` will be documented in this file.

## 2.1.0 - 2026-09-23

### What's new

- **Translations:** 5 new locales (az, fa, hi, pt, uz). (#16)

Thanks to @Elvin-Qulizade (Elvin Qulizada) for the i18n initiative behind these translations — first contributed in jeffersongoncalves/filament-scanner-guard#2 and now rolled out across the Filament plugins. He is credited as co-author.

### What's Changed

* docs: add Buy Me a Coffee sponsor link by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/5
* chore: add GitHub Sponsors to FUNDING.yml by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/6
* ci: standardize update-changelog workflow (2.x) by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/8
* ci: standardize dependabot config by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/9
* chore(deps): Bump the npm-deps group with 2 updates by @dependabot[bot] in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/11
* ci: standardize tests workflow (2.x) by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/14
* feat(i18n): add translations (2.x) by @jeffersongoncalves in https://github.com/jeffersongoncalves/filament-multifactor-passkeys/pull/16

**Full Changelog**: https://github.com/jeffersongoncalves/filament-multifactor-passkeys/compare/2.0.1...2.1.0

## 2.0.1 - 2026-08-17

Fix duplicate WebAuthn listener registration when `@script` is evaluated more than once for the same component, which caused the in-flight authentication/registration ceremony to be aborted (#4).

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