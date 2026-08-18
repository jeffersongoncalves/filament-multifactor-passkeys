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
        // Bind once per component instance. This block can be evaluated again for the
        // same component, and every extra listener turns one click into one more
        // startRegistration call. SimpleWebAuthn aborts the in-flight ceremony each
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
                    // WebAuthn reports a cancellation as an error. NotAllowedError is the
                    // user dismissing the prompt or letting it time out - the browser gives
                    // both the same name on purpose, so a site cannot tell them apart and
                    // probe for a credential. AbortError is the ceremony being called off,
                    // which is what navigating away looks like. Neither is a fault, and
                    // logging them red sends people hunting a bug that is not there.
                    if (err?.name === 'NotAllowedError' || err?.name === 'AbortError') {
                        return;
                    }

                    console.error('Passkey registration failed:', err);
                }
            });
        }
    </script>
    @endscript
</div>
