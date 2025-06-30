@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Form Pemesanan Tiket</h2>

    <form action="/tiket" method="POST">
        @csrf

        <input type="hidden" name="kereta_id" value="{{ $kereta['id'] ?? '' }}">

        <div class="mb-3">
            <label>Nama Kereta</label>
            <input type="text" class="form-control" value="{{ $kereta['nama'] ?? '-' }}" readonly>
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <input type="text" class="form-control" value="{{ $kereta['kelas'] ?? '-' }}" readonly>
        </div>

        <div class="mb-3">
            <label>Waktu Berangkat</label>
            <input type="datetime-local" name="waktu_berangkat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No Kursi</label>
            <input type="text" name="kursi" class="form-control" placeholder="Contoh: A1" required>
        </div>

        <button type="submit" class="btn btn-success">Pesan Tiket</button>
        <a href="/kereta" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
