<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Redirect URL
    |--------------------------------------------------------------------------
    |
    | URL the user is redirected to after a successful passkey ceremony
    | (registration on set-up, or assertion on the MFA challenge).
    | When null, the package falls back to Filament::getCurrentPanel()->getUrl().
    |
    */

    'redirect' => null,
];
