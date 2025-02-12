@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">💊 Daftar Resep Obat</h1>

    <div class="d-flex justify-content gap-3 mb-3">
        <a href="{{ route('apoteker.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('apoteker.resep_obat.history') }}" class="btn btn-info btn-sm">
            <i class="fas fa-history"></i> History Resep
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($resep_obat->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Belum ada resep obat yang tersedia.
        </div>
    @else
        <div class="row">
            @foreach ($resep_obat as $id_konsultasi => $resepGroup)
                @php
                    // Warna kartu berdasarkan status
                    $cardColor = match($resepGroup->first()->status) {
                        'sedang disiapkan' => 'border-warning',
                        'siap' => 'border-success',
                        default => 'border-secondary',
                    };
                @endphp

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card resep-card mb-3 shadow-sm {{ $cardColor }} border-2 hover-shadow">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-notes-medical"></i> Keluhan: <b>{{ $resepGroup->first()->konsultasi->keluhan }}</b>
                            </h6>
                            <hr class="my-2">
                            
                            <p class="mb-1"><i class="fas fa-pills text-success"></i> <b>Obat:</b></p>
                            <ul class="list-group list-group-flush small-list">
                                @foreach ($resepGroup as $resep)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $resep->obat->nama_obat }} ({{ $resep->jumlah }})
                                    </li>
                                @endforeach
                            </ul>

                            <p class="mt-2"><i class="fas fa-sticky-note text-warning"></i> <b>Keterangan:</b> {{ $resepGroup->first()->keterangan ?? '-' }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span>
                                    @if ($resepGroup->first()->status === 'sedang disiapkan')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-hourglass-half"></i> Sedang Disiapkan
                                        </span>
                                    @elseif ($resepGroup->first()->status === 'siap')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Siap
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-info-circle"></i> {{ ucfirst($resepGroup->first()->status) }}
                                        </span>
                                    @endif
                                </span>

                                <a href="{{ route('apoteker.resep_obat.edit', $id_konsultasi) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    /* Menyesuaikan ukuran card agar lebih seragam */
    .resep-card {
        min-height: 270px; /* Menyesuaikan tinggi minimum agar tampilan rapi */
        max-height: 350px; /* Batas tinggi maksimum */
        overflow: hidden; /* Mencegah elemen keluar dari card */
        font-size: 14px; /* Ukuran teks lebih kecil */
        padding: 10px; /* Padding lebih kecil */
    }
    
    .small-list .list-group-item {
        background: transparent;
        border: none;
        padding: 5px 0;
        font-size: 13px;
    }

    .hover-shadow:hover {
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.15) !important;
        transition: box-shadow 0.2s ease-in-out;
    }
</style>
@endsection