@extends('layouts.app')

@section('content')
<div class="container py-4">
    <a href="{{ route('kasir.konsultasi.index') }}" class="btn btn-secondary mb-3">kembali</a>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">🐾 Daftar Ulang Kadaluwarsa</h5>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('kasir.daftarUlang.batalMassal') }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>Nama Hewan</th>
                                <th>Nama Pemilik</th>
                                <th>Tanggal Konsultasi</th>
                                <th>Dokter</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kadaluwarsa as $k)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_ids[]" value="{{ $k->id_konsultasi }}">
                                    </td>
                                    <td>{{ $k->hewan->nama_hewan }}</td>
                                    <td>{{ $k->hewan->pemilik->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($k->tanggal_konsultasi)->format('d M Y') }}</td>
                                    <td>{{ $k->dokter->user->name }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $k->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted">Tidak ada data kadaluwarsa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($kadaluwarsa->count() > 0)
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Batalkan Yang Dipilih
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    // Centang semua checkbox
    document.getElementById('checkAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>
@endsection
