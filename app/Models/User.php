<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            return $this->isPenghuni() && $this->penghuni !== null;
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
        static::creating(function ($user) {
            if (empty($user->role)) {
                $panel = Filament::getCurrentPanel();

                if ($panel) {
                    $user->role = $panel->getId();
                } elseif (static::where('role', 'admin')->count() === 0) {
                    // If created via CLI and no admin exists, default to admin
                    $user->role = 'admin';
                } else {
                    $user->role = 'penghuni';
                }
            }
        });

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
