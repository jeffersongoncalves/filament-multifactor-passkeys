<?php

namespace JeffersonGoncalves\Filament\MultiFactorPasskeys\Tests\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Contracts\HasPasskeyAuthentication;
use Spatie\LaravelPasskeys\Models\Concerns\InteractsWithPasskeys;

class User extends Authenticatable implements HasPasskeyAuthentication
{
    use InteractsWithPasskeys;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasPasskeyAuthentication(): bool
    {
        return $this->passkeys()->exists();
    }
}
