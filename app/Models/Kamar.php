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
    ];
    protected $casts = [
        'fasilitas' => 'array',
        'harga' => 'integer',
        'status' => 'boolean',
    ];
}
