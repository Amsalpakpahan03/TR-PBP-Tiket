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
        try {
            $userId = $request->user_id;

            if (!$userId) {
                return response()->json([
                    'error' => 'User tidak ditemukan, pastikan token dikirim di Authorization header'
                ], 401);
            }

            $data = $request->validate([
                'kereta_id' => 'required|integer',
                'asal' => 'required|string',
                'tujuan' => 'required|string',
                'tanggal' => 'required|date',
                'harga' => 'required|numeric',
                'kursi' => 'required|string'
            ]);

            // Cek duplikat kursi
            $duplikat = Tiket::where('kereta_id', $data['kereta_id'])
                ->where('kursi', $data['kursi'])
                ->whereIn('status', ['pending', 'sukses'])
                ->first();

            if ($duplikat) {
                return response()->json(['message' => 'Kursi sudah dipesan oleh pengguna lain'], 400);
            }

            // Cek kursi ke kereta-service
            $res = Http::get("http://localhost:8002/api/kursi-detail/cek", [
                'kereta_id' => $data['kereta_id'],
                'kode' => $data['kursi']
            ]);

            if (!$res->ok() || !$res['tersedia']) {
                return response()->json(['message' => 'Kursi tidak tersedia'], 400);
            }

            // Simpan tiket pending
            $tiket = Tiket::create([
                'user_id' => $userId,
                'kereta_id' => $data['kereta_id'],
                'asal' => $data['asal'],
                'tujuan' => $data['tujuan'],
                'tanggal' => $data['tanggal'],
                'harga' => $data['harga'],
                'kursi' => $data['kursi'],
                'status' => 'pending'
            ]);

            return response()->json([
                'message' => 'Tiket berhasil dipesan (pending)',
                'tiket' => $tiket
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memesan tiket',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    public function bayar($id)
    {
        $tiket = Tiket::findOrFail($id);

        if ($tiket->status === 'sukses') {
            return response()->json(['message' => 'Tiket sudah dibayar'], 400);
        }

        // Cek kursi ulang ke kereta-service
        $cek = Http::get("http://localhost:8002/api/kursi-detail/cek", [
            'kereta_id' => $tiket->kereta_id,
            'kode' => $tiket->kursi
        ]);

        if (!$cek->ok() || !$cek['tersedia']) {
            return response()->json(['message' => 'Kursi sudah digunakan orang lain'], 400);
        }

        // Tandai terpakai di kereta-service
        $res = Http::put("http://localhost:8002/api/kursi-detail/{$tiket->kereta_id}/{$tiket->kursi}/pakai");

        if ($res->status() !== 200) {
            return response()->json(['message' => 'Gagal bayar, kursi tidak tersedia'], 400);
        }

        $tiket->status = 'sukses';
        $tiket->save();

        return response()->json(['message' => 'Pembayaran berhasil', 'tiket' => $tiket]);
    }

    public function destroy($id)
    {
        Tiket::destroy($id);
        return response()->json(['message' => 'Tiket dibatalkan']);
    }

    public function riwayatUser(Request $request)
    {
        try {
            $userId = $request->user_id;
            $status = $request->query('status'); // ambil dari URL query

            $query = Tiket::where('user_id', $userId);

            if ($status) {
                $query->where('status', $status);
            }

            $riwayat = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'message' => 'Riwayat tiket berhasil diambil',
                'data' => $riwayat
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil riwayat tiket',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

}
