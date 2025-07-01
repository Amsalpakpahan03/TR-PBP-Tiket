<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kereta extends Model
{
    protected $fillable = [
        'nama', 'kelas', 'jurusan', 'tanggal_berangkat', 'jam_berangkat', 'harga', 'nomor_kursi', 'ketersediaan'
    ];

    protected $casts = [
        'nomor_kursi' => 'array',
    ];
}
