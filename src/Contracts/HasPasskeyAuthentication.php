<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys\Contracts;

use Spatie\LaravelPasskeys\Models\Concerns\HasPasskeys;

interface HasPasskeyAuthentication extends HasPasskeys
{
    public function hasPasskeyAuthentication(): bool;
}
