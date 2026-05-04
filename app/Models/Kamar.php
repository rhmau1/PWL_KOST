<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Kamar extends Model
{
    //
    use SoftDeletes;

    protected $table = 'kamar';

    protected $fillable = [
        'id',
        'nomor',
        'jenis',
        'harga',
        'ukuran',
        'fasilitas',
        'is_available',
        'keterangan',
        'images',
        'tipe_penghuni',
        'kapasitas',
        'kos_id',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'harga' => 'integer',
        'is_available' => 'boolean',
        'images' => 'array',
        'kapasitas' => 'integer',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    protected static function booted()
    {
        static::creating(function ($kamar) {
            if (Auth::check() && empty($kamar->kos_id)) {
                $kos = \App\Models\Kos::where('user_id', Auth::id())->first();
                if ($kos) {
                    $kamar->kos_id = $kos->id;
                }
            }
        });
    }
    
}
