<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;

use App\Models\Kereta;
use App\Models\Kursi;
use Illuminate\Http\Request;

class KeretaController extends Controller
{
    public function index()
    {
        return Kereta::with('kursi')->get();
    }

    public function store(Request $request)
    {
        $kereta = Kereta::create(['nama' => $request->nama]);
        Kursi::create(['kereta_id' => $kereta->id, 'jumlah' => $request->jumlah]);
        return response()->json(['message' => 'Kereta ditambahkan', 'data' => $kereta]);
    }

    public function update(Request $request, $id)
    {
        $kereta = Kereta::findOrFail($id);
        $kereta->update(['nama' => $request->nama]);
        return response()->json(['message' => 'Kereta diupdate']);
    }

    public function destroy($id)
    {
        Kereta::destroy($id);
        return response()->json(['message' => 'Kereta dihapus']);
    }

    public function kurangiStok($id, Request $request)
    {
        $kursi = Kursi::where('kereta_id', $id)->first();
        if (!$kursi || $kursi->jumlah < $request->jumlah) {
            return response()->json(['message' => 'Stok kursi tidak cukup'], 400);
        }
        $kursi->jumlah -= $request->jumlah;
        $kursi->save();
        return response()->json(['message' => 'Stok dikurangi']);
    }
}

