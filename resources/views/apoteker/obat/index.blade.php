@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Manajemen Obat</h1>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari obat...">
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Button Tambah & Kembali -->
    <div class="d-flex justify-content mb-4">
        <a href="{{ route('apoteker.dashboard') }}" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('apoteker.obat.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Obat
        </a>
    </div>    

    <!-- Grid List of Drugs -->
    <div class="row" id="drugList">
        @foreach($obats as $obat)
        <div class="col-md-4 mb-4 drug-card">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $obat->nama_obat }}</h5>
                    <p class="card-text"><strong>Jenis:</strong> {{ $obat->jenis_obat }}</p>
                    <p class="card-text">
                        <strong>Stok:</strong> 
                        <span class="badge 
                            {{ $obat->stok < 10 ? 'bg-danger' : 'bg-success' }}">
                            {{ $obat->stok }}
                        </span>
                    </p>
                    <p class="card-text">
                        <strong>Harga:</strong> Rp{{ number_format($obat->harga, 0, ',', '.') }}
                    </p>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('apoteker.obat.edit', $obat->id_obat) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('apoteker.obat.destroy', $obat->id_obat) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- JavaScript Filter -->
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        let filter = this.value.toLowerCase();
        let cards = document.querySelectorAll('.drug-card');

        cards.forEach(card => {
            let name = card.querySelector('.card-title').textContent.toLowerCase();
            if (name.includes(filter)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
</script>
@endsection