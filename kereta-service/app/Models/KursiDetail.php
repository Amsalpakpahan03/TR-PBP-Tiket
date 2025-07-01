<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KursiDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'kereta_id',
        'kode',
        'status'
    ];

    public function kereta()
    {
        return $this->belongsTo(Kereta::class);
    }
}
