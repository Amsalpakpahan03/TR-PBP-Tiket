<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kereta extends Model
{
    protected $table = 'kereta';
    protected $fillable = ['nama'];

    public function kursi() {
        return $this->hasOne(Kursi::class);
    }
}

