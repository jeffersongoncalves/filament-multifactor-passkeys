<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys\Livewire;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Spatie\LaravelPasskeys\Actions\FindPasskeyToAuthenticateAction;
use Spatie\LaravelPasskeys\Actions\GeneratePasskeyAuthenticationOptionsAction;
use Spatie\LaravelPasskeys\Support\Config;

class AuthenticatePasskey extends Component
{
    public string $guard = 'web';

    public ?string $redirectUrl = null;

    #[Locked]
    public ?string $options = null;

    public function mount(string $guard = 'web', ?string $redirectUrl = null): void
    {
        $this->guard = $guard;
        $this->redirectUrl = $redirectUrl;
    }

    public function render(): View
    {
        /** @var view-string $view */
        $view = 'filament-multifactor-passkeys::livewire.authenticate-passkey';

        return view($view);
    }

    public function getOptions(): void
    {
        /** @var GeneratePasskeyAuthenticationOptionsAction $action */
        $action = Config::getAction('generate_passkey_authentication_options', GeneratePasskeyAuthenticationOptionsAction::class);
        $this->options = $action->execute();

        $this->dispatch('passkey-authentication-options-ready', options: json_decode($this->options));
    }

    public function authenticate(string $assertion): void
    {
        if (blank($this->options)) {
            session()->flash('authenticatePasskey::message', __('filament-multifactor-passkeys::login_button.errors.invalid'));

            return;
        }

        /** @var FindPasskeyToAuthenticateAction $findAction */
        $findAction = Config::getAction('find_passkey', FindPasskeyToAuthenticateAction::class);

        $passkey = $findAction->execute($assertion, $this->options);
        $this->options = null;

        $authenticatable = $passkey?->authenticatable;

        if (! $passkey || ! $authenticatable instanceof Authenticatable) {
            session()->flash('authenticatePasskey::message', __('filament-multifactor-passkeys::login_button.errors.invalid'));

            return;
        }

        Auth::guard($this->guard)->login($authenticatable);
        Session::regenerate();

        $passkey->update(['last_used_at' => now()]);

        Notification::make()
            ->title(__('filament-multifactor-passkeys::login_button.notifications.success.title'))
            ->body(__('filament-multifactor-passkeys::login_button.notifications.success.body'))
            ->success()
            ->send();

        $this->redirect($this->redirectUrl ?: url('/'), navigate: false);
    }
}
