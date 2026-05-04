<div>
    <form wire:submit="generateOptions" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                {{ __('filament-multifactor-passkeys::actions/set-up.modal.form.name.label') }}
            </label>
            <input
                wire:model="name"
                type="text"
                autocomplete="off"
                placeholder="{{ __('filament-multifactor-passkeys::actions/set-up.modal.form.name.placeholder') }}"
                class="fi-input mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-base text-gray-950 shadow-sm placeholder:text-gray-400 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500 dark:border-white/10 dark:bg-white/5 dark:text-white sm:text-sm"
            />
            @error('name')
                <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="fi-btn fi-color-primary inline-flex items-center justify-center gap-1.5 rounded-lg bg-primary-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 disabled:opacity-50"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove wire:target="generateOptions,storePasskey">
                {{ __('filament-multifactor-passkeys::actions/set-up.modal.form.submit.label') }}
            </span>
            <span wire:loading wire:target="generateOptions,storePasskey">
                {{ __('filament-multifactor-passkeys::actions/set-up.modal.form.submit.loading_label') }}
            </span>
        </button>
    </form>

    @script
    <script>
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
    </script>
    @endscript
</div>
