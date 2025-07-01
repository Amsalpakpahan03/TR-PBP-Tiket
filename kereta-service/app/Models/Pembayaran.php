<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = ['kereta_id', 'jumlah', 'nama_pembeli'];

    public function kereta()
    {
        return $this->belongsTo(Kereta::class);
    }
}
