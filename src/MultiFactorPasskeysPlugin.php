<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

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
            function () use ($panel): View {
                $redirect = $panel->getUrl() ?? url('/');

                Session::put('passkeys.redirect', $redirect);

                /** @var view-string $view */
                $view = 'filament-multifactor-passkeys::components.login-button';

                return view($view, ['redirect' => $redirect]);
            },
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
