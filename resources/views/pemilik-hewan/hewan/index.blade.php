@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card untuk Daftar Hewan -->
    <div class="card">
        <div class="card-header">
            <h1 class="mb-0">Daftar Hewan</h1>
        </div>
        <div class="card-body">
            <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('pemilik-hewan.hewan.create') }}" class="btn btn-success mb-3">
                Tambah Hewan
            </a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Form Pencarian dan Sorting -->
            <form method="GET" class="row mb-4">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama hewan atau pemilik..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select" id="sortSelect">
                        <option value="">Urutkan</option>
                        <option value="nama_hewan" {{ request('sort') == 'nama_hewan' && request('direction') == 'asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="nama_hewan" {{ request('sort') == 'nama_hewan' && request('direction') == 'desc' ? 'selected' : '' }}>Nama Z-A</option>
                        <option value="created_at" {{ request('sort') == 'created_at' && request('direction') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                        <option value="created_at" {{ request('sort') == 'created_at' && request('direction') == 'asc' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                </div>
                <input type="hidden" name="direction" id="directionInput" value="{{ request('direction', 'asc') }}">
            </form>

            <!-- Daftar Hewan -->
            <ul class="list-group">
                @forelse($hewan as $item)
                <li class="list-group-item d-flex align-items-center p-3">
                    <a href="{{ route('pemilik-hewan.hewan.edit', $item->id_hewan) }}" class="d-flex w-100 text-decoration-none">
                        <!-- Foto Hewan -->
                        <div class="me-3">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Hewan" width="80" height="80" class="rounded-circle" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-hewan.png') }}" alt="Default Foto" width="80" height="80" class="rounded-circle" style="object-fit: cover;">
                            @endif
                        </div>

                        <!-- Informasi Hewan -->
                        <div class="flex-grow-1">
                            <h5 class="mb-1 text-dark">{{ $item->nama_hewan }}</h5>
                            <p class="mb-1 text-muted">
                                <strong>Pemilik:</strong> {{ $item->pemilik->nama ?? '-' }} |
                                <strong>Jenis:</strong> {{ $item->jenis->nama_jenis ?? 'Jenis tidak ditemukan' }} |
                                <strong>JK:</strong> {{ $item->jenkel }} |
                                <strong>Umur:</strong> {{ $item->umur }} bulan |
                                <strong>Berat:</strong> {{ number_format($item->berat, 0, ',', '.') }} gram
                            </p>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex gap-2">
                            @if(!$item->konsultasi()->exists()) 
                                <form action="{{ route('pemilik-hewan.hewan.destroy', $item->id_hewan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hewan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </a>
                </li>
                @empty
                <li class="list-group-item">
                    <p class="mb-0">Belum ada hewan yang terdaftar.</p>
                </li>
                @endforelse
            </ul>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $hewan->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk mengatur arah sort -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sortSelect = document.getElementById('sortSelect');
        const directionInput = document.getElementById('directionInput');

        sortSelect.addEventListener('change', function () {
            const selectedText = sortSelect.options[sortSelect.selectedIndex].text;
            if (selectedText.includes('Z-A') || selectedText.includes('Terbaru')) {
                directionInput.value = 'desc';
            } else {
                directionInput.value = 'asc';
            }
        });
    });
</script>
@endsection
