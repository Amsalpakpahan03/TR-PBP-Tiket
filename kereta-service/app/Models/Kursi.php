<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kursi extends Model
{
    protected $table = 'kursi'; // WAJIB!
    protected $fillable = ['kereta_id', 'jumlah'];

    public function kereta()
    {
        return $this->belongsTo(Kereta::class, 'kereta_id');
    }
}
