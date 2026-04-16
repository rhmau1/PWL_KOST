<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = [
        'user_id',
        'kos_id',
        'kamar_id',
        'tipe',
        'jumlah',
        'bukti_pembayaran',
        'status',
        'tanggal_bayar',
        'catatan',
    ];

    // relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}