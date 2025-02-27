@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Dashboard Kasir</h3>
    </div>

    <div class="row g-3">
        <!-- Card: Daftar Ulang Hari Ini -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-primary border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                    <h6>Daftar Ulang Hari Ini</h6>
                    <h4>{{ $konsultasiCount ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Kelola daftar ulang konsultasi.</p>
                    <a href="{{ route('kasir.konsultasi.index') }}" class="btn btn-light btn-sm">Daftar Ulang</a>
                </div>
            </div>
        </div>

        <!-- Card: Transaksi Belum Dibayar -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-success border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i>
                    <h6>Transaksi Belum Dibayar</h6>
                    <h4>{{ $counttransaksi ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Lihat transaksi yang belum dibayar.</p>
                    <a href="{{ route('kasir.transaksi.list') }}" class="btn btn-light btn-sm">Lihat Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navbar for Mobile -->
<nav class="mobile-nav d-md-none fixed-bottom bg-white shadow py-2">
    <div class="container d-flex justify-content-around">
        <a href="{{ route('kasir.konsultasi.index') }}" class="text-dark text-center">
            <i class="fas fa-calendar-check"></i>
            <p class="small mb-0">Daftar Ulang</p>
        </a>
        <a href="{{ route('kasir.transaksi.list') }}" class="text-dark text-center">
            <i class="fas fa-file-invoice-dollar"></i>
            <p class="small mb-0">Transaksi</p>
        </a>
    </div>
</nav>

<style>
    .mobile-nav a {
        text-decoration: none;
        flex-grow: 1;
        padding: 10px 0;
    }
    .mobile-nav i {
        font-size: 18px;
        display: block;
    }
    .mobile-nav p {
        font-size: 12px;
        margin-top: 2px;
    }
</style>
@endsection
