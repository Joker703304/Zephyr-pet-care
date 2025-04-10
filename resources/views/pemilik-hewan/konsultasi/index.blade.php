@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">📋 Daftar Konsultasi</h1>

    <div class="d-flex justify-content gap-4 mb-3">
        <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('pemilik-hewan.konsultasi_pemilik.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Ajukan Konsultasi
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($konsultasi->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Belum ada konsultasi yang diajukan.
        </div>
    @else
        <div class="row">
            @foreach ($konsultasi as $item)
                @php
                    $cardColor = match($item->status) {
                        'Menunggu' => 'border-warning',
                        'Dibatalkan' => 'border-danger',
                        'Selesai' => 'border-success',
                        default => 'border-secondary',
                    };
                @endphp

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card mb-4 shadow-sm {{ $cardColor }} border-2 hover-shadow">
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

                                @if ($item->status === 'Menunggu')
                                    <form action="{{ route('pemilik-hewan.konsultasi_pemilik.cancel', $item->id_konsultasi) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan konsultasi ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times-circle"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $konsultasi->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
@endsection
