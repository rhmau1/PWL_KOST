<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class LaporanKerusakan extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'laporan_kerusakan';

    protected $fillable = [
        'id_kamar',
        'id_penghuni',
        'jenis_kerusakan',
        'detail_kerusakan',
        'foto_bukti',
        'status',
    ];

    // Relationships
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'id_penghuni');
    }
}
