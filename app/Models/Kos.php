<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    //
    protected $fillable = [
        'user_id',
        'nama_kos',
        'alamat',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kamars()
    {
        return $this->hasMany(Kamar::class);
    }
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
    public function penghunis()
    {
        return $this->hasMany(Penghuni::class);
    }
}
