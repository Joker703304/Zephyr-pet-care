@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Dashboard Apoteker</h3>
    </div>

    <div class="row g-3">
        <!-- Card: Total Obat -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-primary border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-capsules fa-2x mb-2"></i>
                    <h6>Total Obat</h6>
                    <h4>{{ $medicationsCount ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Kelola dan stok obat yang tersedia.</p>
                    <a href="{{ route('apoteker.obat.index') }}" class="btn btn-light btn-sm">Kelola Obat</a>
                </div>
            </div>
        </div>

        <!-- Card: Resep Obat -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-danger border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-prescription-bottle-alt fa-2x mb-2"></i>
                    <h6>Total Resep Obat</h6>
                    <h4>{{ $prescriptions ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Lihat dan proses resep obat.</p>
                    <a href="{{ route('apoteker.resep_obat.index') }}" class="btn btn-light btn-sm">Lihat Resep</a>
                </div>
            </div>
        </div>

<!-- Bottom Navbar for Mobile -->
<nav class="mobile-nav d-md-none fixed-bottom bg-white shadow py-2">
    <div class="container d-flex justify-content-around">
        <a href="{{ route('apoteker.obat.index') }}" class="text-dark text-center">
            <i class="fas fa-capsules"></i>
            <p class="small mb-0">Obat</p>
        </a>
        <a href="{{ route('apoteker.resep_obat.index') }}" class="text-dark text-center">
            <i class="fas fa-prescription-bottle-alt"></i>
            <p class="small mb-0">Resep</p>
        </a>
        <a href="{{ route('apoteker.profile') }}" class="text-dark text-center">
            <i class="fas fa-user-md"></i>
            <p class="small mb-0">Profil</p>
        </a>
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