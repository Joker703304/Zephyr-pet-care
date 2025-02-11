@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">📋 Daftar Konsultasi Hari Ini</h1>

    <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($konsultasi->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Tidak ada konsultasi hari ini.
        </div>
    @else
        <div class="row">
            @foreach ($konsultasi as $item)
                <div class="col-md-6">
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    <i class="fas fa-paw"></i> {{ $item->hewan->nama_hewan ?? 'Tidak ada' }}
                                </h5>
                                <span class="badge bg-secondary">No. {{ $item->no_antrian }}</span>
                            </div>

                            <p class="text-muted mb-1">👨‍⚕️ Dokter: {{ $item->dokter->user->name ?? 'Belum ditentukan' }}</p>
                            <p class="mb-1">🩺 Keluhan: <strong>{{ $item->keluhan }}</strong></p>
                            <p class="text-muted">📅 Tanggal: {{ $item->tanggal_konsultasi }}</p>

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Status dengan ikon -->
                                <span>
                                    @if ($item->status === 'Menunggu')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-hourglass-half"></i> Menunggu
                                        </span>
                                    @elseif ($item->status === 'Dibatalkan')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle"></i> Dibatalkan
                                        </span>
                                    @elseif ($item->status === 'Selesai')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <i class="fas fa-info-circle"></i> {{ $item->status }}
                                        </span>
                                    @endif
                                </span>

                                <!-- Tombol Diagnosis & Panggil Pasien -->
                                <div class="d-flex">
                                    <a href="{{ route('dokter.konsultasi.diagnosis', $item->id_konsultasi) }}"
                                       class="btn btn-info btn-sm me-2">
                                        <i class="fas fa-notes-medical"></i> Diagnosis
                                    </a>

                                    @if ($item->antrian && $item->antrian->status != 'Dipanggil')
                                        <form action="{{ route('dokter.antrian.panggil', $item->antrian->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fas fa-bullhorn"></i> Panggil
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div> <!-- End Status & Aksi -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection