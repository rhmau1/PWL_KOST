<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penghuni extends Model
{
    use SoftDeletes;

    protected $table = 'penghuni';

    protected $fillable = [
        'user_id',
        'nama',
        'no_hp',
        'no_hp_wali',
        'nama_wali',
        'alamat',
        'tanggal_masuk',
        'kos_id',
    ];

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
