<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Livewire\Livewire;

class MultiFactorPasskeysPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-multifactor-passkeys';
    }

    public function register(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            fn (): HtmlString => new HtmlString(
                Livewire::mount('filament-multifactor-passkeys-authenticate', [
                    'guard' => $panel->getAuthGuard(),
                    'redirectUrl' => $panel->getUrl() ?? url('/'),
                ])
            ),
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
