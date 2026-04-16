<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        if ($panel->getId() === 'penghuni') {
            return $this->isPenghuni() && $this->penghuni !== null && $this->penghuni->kos_id !== null;
        }

        return false;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPenghuni()
    {
        return $this->role === 'penghuni';
    }

    public function penghuni()
    {
        return $this->hasOne(Penghuni::class);
    }

    public function kos()
    {
        return $this->hasOne(Kos::class);
    }
public function pembayarans()
{
    return $this->hasMany(Pembayaran::class);
}
    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role === 'penghuni') {
                Penghuni::create([
                    'user_id' => $user->id,
                    'nama' => $user->name,
                ]);
            }
        });
    }
}
