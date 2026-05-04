<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys\Actions;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Contracts\HasPasskeyAuthentication;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\PasskeyAuthentication;

class DisablePasskeyAuthenticationAction
{
    public static function make(PasskeyAuthentication $passkeyAuthentication): Action
    {
        return Action::make('disablePasskeyAuthentication')
            ->label(__('filament-multifactor-passkeys::actions/disable.label'))
            ->color('danger')
            ->icon(Heroicon::LockOpen)
            ->link()
            ->requiresConfirmation()
            ->modalWidth(Width::Medium)
            ->modalIcon(Heroicon::OutlinedLockOpen)
            ->modalHeading(__('filament-multifactor-passkeys::actions/disable.modal.heading'))
            ->modalDescription(__('filament-multifactor-passkeys::actions/disable.modal.description'))
            ->modalSubmitAction(fn (Action $action) => $action
                ->label(__('filament-multifactor-passkeys::actions/disable.modal.actions.submit.label')))
            ->action(function (): void {
                /** @var HasPasskeyAuthentication $user */
                $user = Filament::auth()->user();

                DB::transaction(function () use ($user): void {
                    $user->passkeys()->delete();
                });

                Notification::make()
                    ->title(__('filament-multifactor-passkeys::actions/disable.notifications.disabled.title'))
                    ->success()
                    ->icon(Heroicon::OutlinedLockOpen)
                    ->send();
            })
            ->rateLimit(5);
    }
}
