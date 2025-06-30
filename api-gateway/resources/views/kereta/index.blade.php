@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Daftar Kereta Api</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle shadow-sm">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Nama Kereta</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keretas as $k)
                <tr class="text-center">
                    <td class="fw-semibold">{{ $k['nama'] }}</td>
                    <td>{{ $k['kelas'] }}</td>
                    <td>
                        <a href="/tiket/pesan/{{ $k['id'] }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-ticket-detailed"></i> Pesan Tiket
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
