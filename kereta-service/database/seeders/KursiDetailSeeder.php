<?php

namespace Database\Seeders;

use App\Models\KursiDetail;
use Illuminate\Database\Seeder;

class KursiDetailSeeder extends Seeder
{
    public function run()
    {
        $keretaId = 1; // sesuaikan dengan ID kereta yang ingin kamu isi

        foreach (range('A', 'H') as $row) {
            for ($col = 1; $col <= 10; $col++) {
                KursiDetail::create([
                    'kereta_id' => $keretaId,
                    'kode_kursi' => $row . $col,
                    'status' => false
                ]);
            }
        }
    }
}
