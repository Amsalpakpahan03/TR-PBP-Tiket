<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TiketViewController extends Controller
{
    public function store(Request $req)
    {
        $response = Http::post('http://localhost:8002/api/tiket', [
            'kereta_id' => $req->kereta_id,
            'user_id' => 1, // sementara
            'kursi' => $req->kursi,
            'waktu_berangkat' => $req->waktu_berangkat,
        ]);
        return redirect('/tiket/riwayat');
    }
    public function riwayat()
    {
        $tiketResponse = Http::get('http://localhost:8002/api/tiket');
        $keretaResponse = Http::get('http://localhost:8001/api/kereta');

        $tikets = [];

        if ($tiketResponse->successful() && $keretaResponse->successful()) {
            $tikets = $tiketResponse->json();
            $keretas = collect($keretaResponse->json())->keyBy('id');

            foreach ($tikets as &$tiket) {
                $tiket['kereta'] = $keretas[$tiket['kereta_id']] ?? ['nama' => '-'];
            }
        }

        return view('tiket.riwayat', compact('tikets'));
    }





    public function formPesan($id)
    {
        $kereta = Http::get("http://localhost:8001/api/kereta/{$id}")->json();
        return view('tiket.form', compact('kereta'));
    }


}
