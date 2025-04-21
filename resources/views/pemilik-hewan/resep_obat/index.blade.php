@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">📜 Resep Obat</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        @if ($resep_obat->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Belum ada resep obat yang tersedia.
            </div>
        @else
            <div class="row">
                @foreach ($resep_obat as $id_konsultasi => $resepGroup)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card resep-card mb-3 shadow-sm border-2 hover-shadow d-flex flex-column">
                            <div class="card-body flex-grow-1">
                                <h6 class="card-title">
                                    <i class="fas fa-dog"></i> Hewan:
                                    <b>{{ $resepGroup->first()->konsultasi->hewan->nama_hewan }}</b>
                                </h6>
                                <p><i class="fas fa-comment-medical"></i> Keluhan:
                                    <b>{{ $resepGroup->first()->konsultasi->keluhan }}</b></p>
                                <p><i class="fas fa-notes-medical"></i> Diagnosis:
                                    <b>{{ $resepGroup->first()->konsultasi->diagnosis }}</b></p>

                                <hr class="my-2">

                                <p class="mb-1"><i class="fas fa-pills text-success"></i> <b>Obat & Keterangan:</b></p>
                                <ul class="list-group list-group-flush small-list">
                                    @foreach ($resepGroup as $resep)
                                        @php
                                            $id_konsultasi = $resepGroup->first()->id_konsultasi;
                                        @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $resep->obat->nama_obat }} ({{ $resep->jumlah }})</span>
                                            <span class="badge bg-info text-dark keterangan-badge">
                                                {{ $resep->keterangan ?? '-' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <a href="{{ route('pemilik-hewan.resep_obat.show', $id_konsultasi) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat Rincian
                                </a>
                                <i class="fas fa-file-prescription text-muted"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $resep_obat->links('pagination::bootstrap-4') }}
            </div>
            
        @endif
    </div>

    <style>
        .resep-card {
            display: flex;
            flex-direction: column;
            min-height: 320px;
            max-height: 360px;
            font-size: 14px;
        }

        .resep-card .card-body {
            flex-grow: 1;
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

        .keterangan-badge {
            font-size: 12px;
            padding: 5px 10px;
            white-space: nowrap;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
