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
                'kursi' => 'required|string'
            ]);

            // Ambil detail kereta dari kereta-service
            $keretaResponse = Http::get("http://localhost:8002/api/kereta/{$data['kereta_id']}");

            if (!$keretaResponse->ok()) {
                return response()->json(['message' => 'Kereta tidak ditemukan'], 404);
            }

            $kereta = $keretaResponse->json();

            // Cek apakah kursi sudah dipesan
            $duplikat = Tiket::where('kereta_id', $data['kereta_id'])
                ->where('kursi', $data['kursi'])
                ->whereIn('status', ['pending', 'sukses'])
                ->first();

            if ($duplikat) {
                return response()->json(['message' => 'Kursi sudah dipesan oleh pengguna lain'], 400);
            }

            // Cek ketersediaan kursi
            $cekKursi = Http::get("http://localhost:8002/api/kursi-detail/cek", [
                'kereta_id' => $data['kereta_id'],
                'kode' => $data['kursi']
            ]);

            if (!$cekKursi->ok() || !$cekKursi['tersedia']) {
                return response()->json(['message' => 'Kursi tidak tersedia'], 400);
            }

            // Simpan tiket
            $tiket = Tiket::create([
                'user_id' => $userId,
                'kereta_id' => $data['kereta_id'],
                'jurusan' => $kereta['jurusan'],
                'tanggal' => $kereta['tanggal_berangkat'],
                'harga' => $kereta['harga'],
                'kursi' => $data['kursi'],
                'status' => 'pending'
            ]);

            return response()->json([
                'message' => 'Tiket berhasil dipesan (pendding) Lakukan Pembayaran Ke My Ticket ',
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
        try {
            $tiket = Tiket::findOrFail($id);

            if ($tiket->status === 'sukses') {
                return response()->json(['message' => 'Tiket sudah dibayar'], 400);
            }

            $tiket->status = 'sukses';
            $tiket->save();

            return response()->json(['message' => 'Tiket berhasil dibayar', 'data' => $tiket]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membayar tiket',
                'error' => $e->getMessage()
            ], 500);
        }
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
            $status = $request->query('status');

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
