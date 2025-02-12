@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">📜 History Resep Obat</h1>

    <div class="d-flex justify-content-start mb-3">
        <a href="{{ route('apoteker.resep_obat.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($resep_obat->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Belum ada resep obat dalam riwayat.
        </div>
    @else
        <div class="row">
            @foreach ($resep_obat as $id_konsultasi => $resepGroup)
                @php
                    // Warna kartu berdasarkan status
                    $cardColor = match($resepGroup->first()->status) {
                        'sedang disiapkan' => 'border-warning',
                        'selesai' => 'border-success',
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
                            
                            <p class="mb-1"><i class="fas fa-pills text-success"></i> <b>Obat & Keterangan:</b></p>
                            <ul class="list-group list-group-flush small-list">
                                @foreach ($resepGroup as $resep)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $resep->obat->nama_obat }} ({{ $resep->jumlah }})</span>
                                        <span class="badge bg-info text-dark keterangan-badge">
                                            {{ $resep->keterangan ?? '-' }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>

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

    .status-badge {
        font-size: 14px;
        padding: 6px 12px;
        color: white;
    }

    .badge-warning { background-color: #ffc107; }
    .badge-success { background-color: #28a745; }
    .badge-secondary { background-color: #6c757d; }

    .keterangan-badge {
        font-size: 12px;
        padding: 5px 10px;
        white-space: nowrap; /* Mencegah teks terlalu panjang */
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection