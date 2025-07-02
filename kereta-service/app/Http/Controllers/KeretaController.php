<?php

namespace App\Http\Controllers;

use App\Models\Kereta;
use App\Models\KursiDetail;
use Illuminate\Http\Request;

class KeretaController extends Controller
{
    public function index()
    {
        return Kereta::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'tanggal_berangkat' => 'required|date',
            'jam_berangkat' => 'required',
            'harga' => 'required|numeric',
            'ketersediaan' => 'required|integer|min:1'
        ]);

        $nomor_kursi = [];
        for ($i = 1; $i <= $request->ketersediaan; $i++) {
            $nomor_kursi[] = "A$i";
        }

        $kereta = Kereta::create([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'jam_berangkat' => $request->jam_berangkat,
            'harga' => $request->harga,
            'nomor_kursi' => $nomor_kursi,
            'ketersediaan' => $request->ketersediaan
        ]);

        foreach ($nomor_kursi as $kode) {
            KursiDetail::create([
                'kereta_id' => $kereta->id,
                'kode' => $kode,
                'status' => 'kosong'
            ]);
        }

        return response()->json(['message' => 'Kereta ditambahkan', 'data' => $kereta]);
    }

    public function update(Request $request, $id)
    {
        $kereta = Kereta::findOrFail($id);
        $kereta->update($request->all());
        return response()->json(['message' => 'Kereta diupdate']);
    }

    public function destroy($id)
    {
        Kereta::destroy($id);
        return response()->json(['message' => 'Kereta dihapus']);
    }

    public function kursiKosong($kereta_id)
    {
        $kursiKosong = KursiDetail::where('kereta_id', $kereta_id)
            ->where('status', 'kosong')
            ->pluck('kode');

        return response()->json($kursiKosong);
    }

    public function cekKursi(Request $request)
    {
        $keretaId = $request->kereta_id;
        $kode = $request->kode;

        $kursi = KursiDetail::where('kereta_id', $keretaId)
            ->where('kode', $kode)
            ->first();

        if (!$kursi) {
            return response()->json(['tersedia' => false, 'message' => 'Kursi tidak ditemukan'], 404);
        }

        return response()->json(['tersedia' => $kursi->status === 'kosong']);
    }

    public function tandaiTerpakai($kereta_id, $kode)
    {
        try {
            $kursi = KursiDetail::where('kereta_id', $kereta_id)
                ->where('kode', $kode)
                ->first();

            if (!$kursi) {
                return response()->json(['message' => 'Kursi tidak ditemukan'], 404);
            }

            if ($kursi->status === 'terpakai') {
                return response()->json(['message' => 'Kursi sudah dipakai'], 400);
            }

            $kursi->status = 'terpakai';
            $kursi->save();

            return response()->json(['message' => 'Kursi berhasil ditandai sebagai terpakai'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menandai kursi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
