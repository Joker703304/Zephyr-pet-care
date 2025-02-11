@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4"><i class="fas fa-file-invoice-dollar"></i> Daftar Transaksi</h1>

    <a href="{{ route('pemilik-hewan.dashboard') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    @if ($transaksi->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Tidak ada transaksi yang tersedia.
        </div>
    @else
        <div class="row">
            @foreach ($transaksi as $item)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-user"></i> {{ $item->konsultasi->hewan->pemilik->nama }}
                        </h5>
                        <p class="card-text">
                            <i class="fas fa-list-ol"></i> <strong>No Antrian:</strong> 
                            <span class="badge bg-info">{{ $item->konsultasi->no_antrian }}</span><br>

                            <i class="fas fa-hashtag"></i> <strong>ID Transaksi:</strong> {{ $item->id_transaksi }}<br>

                            <i class="fas fa-money-bill-wave"></i> <strong>Total Harga:</strong> 
                            <span class="text-success">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span><br>

                            <i class="fas fa-wallet"></i> <strong>Status Pembayaran:</strong> 
                            <span class="badge {{ $item->status_pembayaran === 'Belum Dibayar' ? 'bg-danger' : 'bg-success' }}">
                                <i class="fas {{ $item->status_pembayaran === 'Belum Dibayar' ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                                {{ ucfirst($item->status_pembayaran) }}
                            </span>
                        </p>
                        <div class="d-grid">
                            @if ($item->status_pembayaran === 'Belum Dibayar')
                                <button class="btn btn-warning" disabled>
                                    <i class="fas fa-exclamation-circle"></i> Menunggu Pembayaran
                                </button>
                            @else
                                <a href="{{ route('pemilik-hewan.transaksi.rincian', $item->id_transaksi) }}" class="btn btn-primary">
                                    <i class="fas fa-receipt"></i> Lihat Rincian
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection