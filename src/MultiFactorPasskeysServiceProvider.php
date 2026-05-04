<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Route;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Livewire\RegisterPasskey;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MultiFactorPasskeysServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-multifactor-passkeys')
            ->hasTranslations()
            ->hasViews()
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        Livewire::component('filament-multifactor-passkeys-register', RegisterPasskey::class);

        FilamentAsset::register([
            Js::make('filament-multifactor-passkeys', __DIR__.'/../resources/dist/passkey.js'),
            Css::make('filament-multifactor-passkeys', __DIR__.'/../resources/dist/passkey.css'),
        ], package: 'jeffersongoncalves/filament-multifactor-passkeys');

        $this->registerPasskeyRoutes();
    }

    protected function registerPasskeyRoutes(): void
    {
        if (! Route::hasMacro('passkeys')) {
            return;
        }

        if (Route::has('passkeys.login') && Route::has('passkeys.authentication_options')) {
            return;
        }

        Route::middleware('web')->group(fn () => Route::passkeys());
    }
}
