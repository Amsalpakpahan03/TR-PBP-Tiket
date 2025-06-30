<?php


namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiketController extends Controller
{
    public function index()
    {
        return Tiket::all();
    }

    public function userTiket($id)
    {
        return Tiket::where('user_id', $id)->where('status', 'sukses')->get();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // Kurangi stok di kereta-service
        $res = Http::put("http://localhost:8002/api/kereta/{$data['kereta_id']}/kurangi-stok", [
            'jumlah' => 1
        ]);

        if ($res->status() !== 200) {
            return response()->json(['message' => 'Gagal memesan, kursi tidak cukup'], 400);
        }

        $tiket = Tiket::create([
            'user_id' => $data['user_id'],
            'kereta_id' => $data['kereta_id'],
            'asal' => $data['asal'],
            'tujuan' => $data['tujuan'],
            'tanggal' => $data['tanggal'],
            'harga' => $data['harga'],
            'status' => 'sukses'
        ]);

        return response()->json(['message' => 'Tiket dipesan', 'tiket' => $tiket]);
    }

    public function destroy($id)
    {
        Tiket::destroy($id);
        return response()->json(['message' => 'Tiket dibatalkan']);
    }
}
