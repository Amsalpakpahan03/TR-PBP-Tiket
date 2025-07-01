@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pesan Tiket</h2>
    <form method="POST" action="{{ route('tiket.store') }}">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="text" name="user_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kereta_id" class="form-label">Pilih Kereta</label>
            <select name="kereta_id" class="form-control" id="keretaSelect">
                @foreach ($keretas as $kereta)
                    <option value="{{ $kereta->id }}">{{ $kereta->nama }} - {{ $kereta->kelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kursi" class="form-label">Pilih Kursi Tersedia</label>
            <select name="kursi" class="form-control" id="kursiSelect">
                <!-- Diisi otomatis dengan JavaScript -->
            </select>
        </div>

        <div class="mb-3">
            <label for="asal" class="form-label">Asal</label>
            <input type="text" name="asal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" name="tujuan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Pesan</button>
    </form>
</div>

<script>
    const keretaSelect = document.getElementById('keretaSelect');
    const kursiSelect = document.getElementById('kursiSelect');

    keretaSelect.addEventListener('change', function () {
        const keretaId = this.value;
        fetch(`http://localhost:8002/api/kereta/${keretaId}/kursi-tersedia`)
            .then(res => res.json())
            .then(data => {
                kursiSelect.innerHTML = '';
                data.forEach(kursi => {
                    const option = document.createElement('option');
                    option.value = kursi;
                    option.text = kursi;
                    kursiSelect.appendChild(option);
                });
            });
    });

    // Trigger awal saat halaman pertama dibuka
    keretaSelect.dispatchEvent(new Event('change'));
</script>
@endsection
