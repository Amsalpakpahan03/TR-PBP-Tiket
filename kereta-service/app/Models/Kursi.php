<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kursi extends Model
{
    protected $table = 'kursi';
    protected $fillable = ['kereta_id', 'jumlah'];

    public function kereta() {
        return $this->belongsTo(Kereta::class);
    }
}
