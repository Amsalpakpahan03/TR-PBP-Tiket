<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = [
        'user_id',
        'kereta_id',
        'jurusan',
        'tanggal',
        'harga',
        'kursi',
        'status'
    ];
}
