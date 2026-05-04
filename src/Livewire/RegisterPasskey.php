<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys\Livewire;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\LaravelPasskeys\Actions\GeneratePasskeyRegisterOptionsAction;
use Spatie\LaravelPasskeys\Actions\StorePasskeyAction;
use Spatie\LaravelPasskeys\Models\Concerns\HasPasskeys;
use Spatie\LaravelPasskeys\Support\Config;
use Throwable;

class RegisterPasskey extends Component
{
    public ?string $redirectUrl = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    public function render(): View
    {
        /** @var view-string $view */
        $view = 'filament-multifactor-passkeys::livewire.register-passkey';

        return view($view);
    }

    public function generateOptions(): void
    {
        $this->validate();

        /** @var GeneratePasskeyRegisterOptionsAction $action */
        $action = Config::getAction('generate_passkey_register_options', GeneratePasskeyRegisterOptionsAction::class);
        $options = $action->execute($this->currentUser());

        session()->put('passkey-registration-options', $options);

        $this->dispatch('passkey-registration-options-ready', options: json_decode($options));
    }

    public function storePasskey(string $passkey): void
    {
        /** @var StorePasskeyAction $action */
        $action = Config::getAction('store_passkey', StorePasskeyAction::class);

        try {
            $action->execute(
                $this->currentUser(),
                $passkey,
                session()->pull('passkey-registration-options') ?? '',
                request()->getHost(),
                ['name' => $this->name]
            );
        } catch (Throwable) {
            throw ValidationException::withMessages([
                'name' => __('filament-multifactor-passkeys::actions/set-up.modal.form.errors.failed'),
            ]);
        }

        Notification::make()
            ->title(__('filament-multifactor-passkeys::actions/set-up.notifications.enabled.title'))
            ->success()
            ->send();

        $this->redirect($this->redirectUrl ?: url('/'), navigate: true);
    }

    protected function currentUser(): HasPasskeys
    {
        /** @var HasPasskeys $user */
        $user = Filament::auth()->user() ?? auth()->user();

        return $user;
    }
}
