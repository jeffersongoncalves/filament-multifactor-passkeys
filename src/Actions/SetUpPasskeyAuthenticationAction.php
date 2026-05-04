<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys\Actions;

use Filament\Actions\Action;
use Filament\Schemas\Components\View;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\PasskeyAuthentication;

class SetUpPasskeyAuthenticationAction
{
    public static function make(PasskeyAuthentication $passkeyAuthentication): Action
    {
        return Action::make('setUpPasskeyAuthentication')
            ->label(__('filament-multifactor-passkeys::actions/set-up.label'))
            ->color('primary')
            ->icon(Heroicon::FingerPrint)
            ->link()
            ->modalWidth(Width::Large)
            ->modalIcon(Heroicon::OutlinedFingerPrint)
            ->modalIconColor('primary')
            ->modalHeading(__('filament-multifactor-passkeys::actions/set-up.modal.heading'))
            ->modalDescription(__('filament-multifactor-passkeys::actions/set-up.modal.description'))
            ->schema([
                View::make('filament-multifactor-passkeys::components.create')
                    ->viewData([
                        'redirect' => $passkeyAuthentication->getRedirectUrl(),
                    ]),
            ])
            ->modalSubmitAction(false)
            ->modalCancelActionLabel(__('filament-multifactor-passkeys::actions/set-up.modal.actions.cancel.label'));
    }
}
