@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Dashboard Pemilik Hewan</h3>
    </div>

    <div class="row g-3">
         <!-- Card: Hewan Peliharaan -->
         <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-primary border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-paw fa-2x mb-2"></i>
                    <h6>Hewan Peliharaan Anda</h6>
                    <h4>{{ $animalsCount ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Kelola hewan peliharaan Anda.</p>
                    <a href="{{ route('pemilik-hewan.hewan.index') }}" class="btn btn-light btn-sm">Lihat Hewan</a>
                </div>
            </div>
        </div>

        <!-- Card: Konsultasi -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-warning border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-comments fa-2x mb-2"></i>
                    <h6>Total Konsultasi</h6>
                    <h4>{{ $consultationsCount ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Ajukan dan lihat riwayat konsultasi.</p>
                    @if($pemilikHewan)
                        <a href="{{ route('pemilik-hewan.konsultasi_pemilik.index') }}" class="btn btn-light btn-sm">Lihat Konsultasi</a>
                    @else
                        <a href="{{ route('pemilik-hewan.pemilik_hewan.create') }}" class="btn btn-secondary btn-sm">Isi Data</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card: Resep Obat -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-danger border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-prescription-bottle-alt fa-2x mb-2"></i>
                    <h6>Resep Obat</h6>
                    <h4>{{ $prescriptions ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Lihat daftar resep obat.</p>
                    <a href="{{ route('pemilik-hewan.resep_obat.index') }}" class="btn btn-light btn-sm">Lihat Resep</a>
                </div>
            </div>
        </div>

        <!-- Card: Riwayat Transaksi -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-success border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i>
                    <h6>Riwayat Transaksi</h6>
                    <h4>{{ $transaksiCount ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Lihat dan kelola transaksi Anda.</p>
                    <a href="{{ route('pemilik-hewan.transaksi.list') }}" class="btn btn-light btn-sm">Lihat Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navbar for Mobile -->
<nav class="mobile-nav d-md-none fixed-bottom bg-white shadow py-2">
    <div class="container d-flex justify-content-around">
        <a href="{{ route('pemilik-hewan.hewan.index') }}" class="text-dark text-center">
            <i class="fas fa-paw"></i>
            <p class="small mb-0">Hewan</p>
        </a>
        <a href="{{ route('pemilik-hewan.konsultasi_pemilik.index') }}" class="text-dark text-center">
            <i class="fas fa-comments"></i>
            <p class="small mb-0">Konsultasi</p>
        </a>
        <a href="{{ route('pemilik-hewan.resep_obat.index') }}" class="text-dark text-center">
            <i class="fas fa-prescription-bottle-alt"></i>
            <p class="small mb-0">Resep</p>
        </a>
        <a href="{{ route('pemilik-hewan.transaksi.list') }}" class="text-dark text-center">
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