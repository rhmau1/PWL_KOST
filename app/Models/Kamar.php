<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kamar extends Model
{
    //
    use SoftDeletes;

    protected $table = 'kamar';

    protected $primaryKey = 'nomor';

    protected $fillable = [
        'nomor',
        'jenis',
        'harga',
        'ukuran',
        'fasilitas',
        'status',
        'keterangan',
        'images',
        'tipe_penghuni',
        'kapasitas',
        'is_furnished',
        'aturan_khusus',
        'kos_id',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'harga' => 'integer',
        'status' => 'boolean',
        'images' => 'array',
        'kapasitas' => 'integer',
        'is_furnished' => 'boolean',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
    public function pembayarans()
{
    return $this->hasMany(Pembayaran::class);
}
}
