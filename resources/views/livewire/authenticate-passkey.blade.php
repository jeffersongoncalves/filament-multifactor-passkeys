<div class="fmfp-login-wrapper">
    <div class="fmfp-divider">
        <span>{{ __('filament-multifactor-passkeys::login_button.or') }}</span>
    </div>

    <x-filament::button
        type="button"
        color="gray"
        icon="heroicon-o-finger-print"
        wire:click="getOptions"
        wire:loading.attr="disabled"
        wire:target="getOptions,authenticate"
        class="fmfp-login-button"
    >
        <span wire:loading.remove wire:target="getOptions,authenticate">
            {{ __('filament-multifactor-passkeys::login_button.label') }}
        </span>
        <span wire:loading wire:target="getOptions,authenticate">
            {{ __('filament-multifactor-passkeys::login_button.loading_label') }}
        </span>
    </x-filament::button>

    @if ($message = session()->get('authenticatePasskey::message'))
        <div class="fmfp-login-error">{{ $message }}</div>
    @endif

    @script
    <script>
        // Bind once per component instance. @script can be evaluated again for the same
        // component, and every extra listener turns one click into one more
        // startAuthentication call. SimpleWebAuthn aborts the in-flight ceremony each
        // time a new one starts, so the real one dies with:
        //   AbortError: Cancelling existing WebAuthn API call for new one
        window.__fmfpAuthenticateBound = window.__fmfpAuthenticateBound || new Set();

        if (! window.__fmfpAuthenticateBound.has($wire.id)) {
            window.__fmfpAuthenticateBound.add($wire.id);

            Livewire.on('passkey-authentication-options-ready', async function (eventData) {
                const payload = Array.isArray(eventData) ? eventData[0] : eventData;
                const options = payload?.options ?? payload;

                if (! window.FilamentMultiFactorPasskeys) {
                    console.error('filament-multifactor-passkeys assets not loaded');
                    return;
                }

                try {
                    const assertion = await window.FilamentMultiFactorPasskeys.startAuthentication({ optionsJSON: options });
                    @this.call('authenticate', JSON.stringify(assertion));
                } catch (err) {
                    console.error('Passkey authentication failed:', err);
                }
            });
        }
    </script>
    @endscript
</div>
