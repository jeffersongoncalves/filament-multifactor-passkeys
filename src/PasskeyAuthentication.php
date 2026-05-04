<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys;

use Closure;
use Filament\Auth\MultiFactor\Contracts\MultiFactorAuthenticationProvider;
use Filament\Facades\Filament;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\View;
use Illuminate\Contracts\Auth\Authenticatable;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Actions\DisablePasskeyAuthenticationAction;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Actions\SetUpPasskeyAuthenticationAction;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Contracts\HasPasskeyAuthentication;
use LogicException;

class PasskeyAuthentication implements MultiFactorAuthenticationProvider
{
    protected ?Closure $resolveRedirectUrlUsing = null;

    public function getId(): string
    {
        return 'passkey';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function redirectUrlUsing(?Closure $callback): static
    {
        $this->resolveRedirectUrlUsing = $callback;

        return $this;
    }

    public function getRedirectUrl(): string
    {
        if ($this->resolveRedirectUrlUsing) {
            return ($this->resolveRedirectUrlUsing)();
        }

        return Filament::getCurrentPanel()?->getUrl() ?? url('/');
    }

    public function getLoginFormLabel(): string
    {
        return __('filament-multifactor-passkeys::provider.login_form.label');
    }

    public function isEnabled(Authenticatable $user): bool
    {
        if (! ($user instanceof HasPasskeyAuthentication)) {
            throw new LogicException('The user model must implement the ['.HasPasskeyAuthentication::class.'] interface to use passkey authentication.');
        }

        return $user->hasPasskeyAuthentication();
    }

    public function getManagementSchemaComponents(): array
    {
        $user = Filament::auth()->user();

        return [
            Actions::make($this->getActions())
                ->label(__('filament-multifactor-passkeys::provider.management_schema.actions.label'))
                ->belowContent(__('filament-multifactor-passkeys::provider.management_schema.actions.below_content'))
                ->afterLabel(fn (): Text => $this->isEnabled($user)
                    ? Text::make(__('filament-multifactor-passkeys::provider.management_schema.actions.messages.enabled'))
                        ->badge()
                        ->color('success')
                    : Text::make(__('filament-multifactor-passkeys::provider.management_schema.actions.messages.disabled'))
                        ->badge()),
        ];
    }

    public function getActions(): array
    {
        $user = Filament::auth()->user();

        return [
            SetUpPasskeyAuthenticationAction::make($this)
                ->hidden(fn (): bool => $this->isEnabled($user)),
            DisablePasskeyAuthenticationAction::make($this)
                ->visible(fn (): bool => $this->isEnabled($user)),
        ];
    }

    public function getChallengeFormComponents(Authenticatable $user): array
    {
        return [
            View::make('filament-multifactor-passkeys::components.authenticate')
                ->viewData([
                    'redirect' => $this->getRedirectUrl(),
                ]),
        ];
    }
}
