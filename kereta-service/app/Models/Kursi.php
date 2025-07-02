<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursi extends Model
{
    use HasFactory;

    // Nama tabel di database (jika tidak sesuai konvensi Laravel)
    protected $table = 'kursi'; // atau 'kursis' jika kamu pakai default migration

    // Kolom yang bisa diisi
    protected $fillable = [
        'kereta_id',
        'kode',
        'terpakai',
    ];

    // Cast kolom 'terpakai' ke boolean
    protected $casts = [
        'terpakai' => 'boolean',
    ];

    // Matikan timestamps kalau tidak pakai created_at / updated_at
    public $timestamps = false;
}
