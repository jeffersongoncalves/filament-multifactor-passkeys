@props(['redirect' => null])

<div class="fmfp-login-wrapper">
    <div class="fmfp-divider">
        <span>{{ __('filament-multifactor-passkeys::login_button.or') }}</span>
    </div>

    <form
        id="fmfp-passkey-login-form"
        method="POST"
        action="{{ route('passkeys.login') }}"
        class="fmfp-login-form"
    >
        @csrf
        <input type="hidden" name="start_authentication_response" value="" />

        <x-filament::button
            type="button"
            color="gray"
            icon="heroicon-o-finger-print"
            onclick="window.fmfpLoginWithPasskey()"
            class="fmfp-login-button"
        >
            {{ __('filament-multifactor-passkeys::login_button.label') }}
        </x-filament::button>
    </form>

    @if ($message = session()->get('authenticatePasskey::message'))
        <div class="fmfp-login-error">{{ $message }}</div>
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
