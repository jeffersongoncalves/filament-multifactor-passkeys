<div>
    <div class="fmfp-form">
        <div class="fmfp-field">
            <label class="fmfp-label" for="fmfp-passkey-name">
                {{ __('filament-multifactor-passkeys::actions/set-up.modal.form.name.label') }}
            </label>
            <input
                id="fmfp-passkey-name"
                wire:model="name"
                wire:keydown.enter="generateOptions"
                type="text"
                autocomplete="off"
                placeholder="{{ __('filament-multifactor-passkeys::actions/set-up.modal.form.name.placeholder') }}"
                class="fmfp-input"
            />
            @error('name')
                <p class="fmfp-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="fmfp-actions">
            <x-filament::button
                type="button"
                wire:click="generateOptions"
                wire:loading.attr="disabled"
                wire:target="generateOptions,storePasskey"
            >
                <span wire:loading.remove wire:target="generateOptions,storePasskey">
                    {{ __('filament-multifactor-passkeys::actions/set-up.modal.form.submit.label') }}
                </span>
                <span wire:loading wire:target="generateOptions,storePasskey">
                    {{ __('filament-multifactor-passkeys::actions/set-up.modal.form.submit.loading_label') }}
                </span>
            </x-filament::button>
        </div>
    </div>

    @script
    <script>
        // Bind once per component instance. @script can be evaluated again for the same
        // component, and every extra listener turns one click into one more
        // startAuthentication call. SimpleWebAuthn aborts the in-flight ceremony each
        // time a new one starts, so the real one dies with:
        //   AbortError: Cancelling existing WebAuthn API call for new one
        window.__fmfpRegisterBound = window.__fmfpRegisterBound || new Set();

        if (! window.__fmfpRegisterBound.has($wire.id)) {
            window.__fmfpRegisterBound.add($wire.id);

            Livewire.on('passkey-registration-options-ready', async function (eventData) {
                const payload = Array.isArray(eventData) ? eventData[0] : eventData;
                const options = payload?.options ?? payload;

                if (! window.FilamentMultiFactorPasskeys) {
                    console.error('filament-multifactor-passkeys assets not loaded');
                    return;
                }

                try {
                    const passkey = await window.FilamentMultiFactorPasskeys.startRegistration({ optionsJSON: options });
                    @this.call('storePasskey', JSON.stringify(passkey));
                } catch (err) {
                    console.error('Passkey registration failed:', err);
                }
            });
        }
    </script>
    @endscript
</div>
