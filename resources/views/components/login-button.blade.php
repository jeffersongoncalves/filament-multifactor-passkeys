@props(['redirect' => null])

<div class="fmfp-login-wrapper" style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 1rem;">
    <div class="fmfp-divider" style="position: relative; text-align: center; font-size: 0.75rem; font-weight: 500; color: rgb(107 114 128); text-transform: uppercase; letter-spacing: 0.05em;">
        <span style="position: relative; padding: 0 0.75rem; background-color: inherit;">{{ __('filament-multifactor-passkeys::login_button.or') }}</span>
        <span aria-hidden="true" style="position: absolute; left: 0; right: 0; top: 50%; height: 1px; background-color: rgb(229 231 235); z-index: -1;"></span>
    </div>

    <form
        id="fmfp-passkey-login-form"
        method="POST"
        action="{{ route('passkeys.login') }}"
        class="fmfp-login-form"
        style="display: flex; justify-content: center;"
    >
        @csrf
        <input type="hidden" name="start_authentication_response" value="" />

        <x-filament::button
            type="button"
            color="gray"
            icon="heroicon-o-finger-print"
            onclick="window.fmfpLoginWithPasskey()"
            class="fmfp-login-button"
            style="margin-top: 0.75rem; width: 100%; justify-content: center;"
        >
            {{ __('filament-multifactor-passkeys::login_button.label') }}
        </x-filament::button>
    </form>

    @if ($message = session()->get('authenticatePasskey::message'))
        <div class="fmfp-login-error" style="padding: 0.75rem 1rem; font-size: 0.875rem; color: rgb(220 38 38); background-color: rgb(254 226 226); border: 1px solid rgb(252 165 165); border-radius: 0.5rem;">{{ $message }}</div>
    @endif
</div>

<script>
    window.fmfpLoginWithPasskey = async function () {
        if (! window.FilamentMultiFactorPasskeys) {
            console.error('filament-multifactor-passkeys assets not loaded');
            return;
        }

        try {
            const response = await fetch('{{ route('passkeys.authentication_options') }}', {
                headers: { 'Accept': 'application/json' },
            });
            const options = await response.json();
            const assertion = await window.FilamentMultiFactorPasskeys.startAuthentication({ optionsJSON: options });

            const form = document.getElementById('fmfp-passkey-login-form');
            form.querySelector('[name="start_authentication_response"]').value = JSON.stringify(assertion);
            form.submit();
        } catch (err) {
            console.error('Passkey authentication failed:', err);
        }
    };
</script>
