@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Pemesanan Tiket</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Kereta</th>
                <th>Kode Tiket</th>
                <th>Kursi</th>
                <th>Waktu Berangkat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tikets as $tiket)
                <tr>
                    <td>{{ $tiket['kereta']['nama'] ?? '-' }}</td>
                    <td>{{ $tiket['kode_tiket'] }}</td>
                    <td>{{ $tiket['kursi'] }}</td>
                    <td>{{ $tiket['waktu_berangkat'] }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada tiket ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
