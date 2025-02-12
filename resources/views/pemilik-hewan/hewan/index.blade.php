@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card untuk Daftar Hewan -->
    <div class="card">
        <div class="card-header">
            <h1 class="mb-0">Daftar Hewan</h1>
        </div>
        <div class="card-body">
            <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ route('pemilik-hewan.hewan.create') }}" class="btn btn-success mb-3">Tambah Hewan</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Daftar Hewan -->
            <ul class="list-group">
                @foreach($hewan as $item)
                <li class="list-group-item d-flex align-items-center p-3">
                    <!-- Link untuk mengarahkan ke halaman detail -->
                    <a href="{{ route('pemilik-hewan.hewan.edit', $item->id_hewan) }}" class="d-flex w-100 text-decoration-none">
                        <!-- Foto Hewan -->
                        <div class="me-3">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Hewan" width="80" height="80" class="rounded-circle" style="object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-hewan.jpg') }}" alt="Default Foto" width="80" height="80" class="rounded-circle" style="object-fit: cover;">
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
                            {{-- <a href="{{ route('pemilik-hewan.hewan.edit', $item->id_hewan) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                
                            @if(!$item->konsultasi()->exists()) 
                                <form action="{{ route('pemilik-hewan.hewan.destroy', $item->id_hewan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hewan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @else
                                {{-- <button class="btn btn-secondary btn-sm" disabled>Hapus</button> --}}
                            @endif
                        </div>
                    </a>
                </li>        
                @endforeach
            </ul>       
        </div>
    </div>
</div>
@endsection