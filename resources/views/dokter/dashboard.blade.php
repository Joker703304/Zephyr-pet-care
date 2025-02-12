@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Dashboard Dokter</h3>
    </div>

    <div class="row g-3">
        <!-- Card: Pasien Hari Ini -->
        <div class="col-md-6">
            <div class="card shadow-sm text-white bg-primary border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-stethoscope fa-2x mb-2"></i>
                    <h6>Pasien Hari Ini</h6>
                    <h4>{{ $countPerawatan ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Total pasien terdaftar hari ini.</p>
                    <a href="{{ route('dokter.konsultasi.index') }}" class="btn btn-light btn-sm">Lihat</a>
                </div>
            </div>
        </div>

        <!-- Card: Jadwal Dokter -->
        <div class="col-md-6">
            <div class="card shadow-sm text-white bg-success border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                    <h6>Jadwal Dokter</h6>
                    <h4>{{ $jadwalBulanIni ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Total kegiatan bulan ini.</p>
                    <a href="{{ route('dokter.jadwal.dokter') }}" class="btn btn-light btn-sm">Lihat</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navbar for Mobile -->
<nav class="mobile-nav d-md-none fixed-bottom bg-white shadow py-2">
    <div class="container d-flex justify-content-around">
        <a href="{{ route('dokter.konsultasi.index') }}" class="text-dark text-center">
            <i class="fas fa-user-injured"></i>
            <p class="small mb-0">Pasien</p>
        </a>
        <a href="{{ route('dokter.jadwal.dokter') }}" class="text-dark text-center">
            <i class="fas fa-calendar-alt"></i>
            <p class="small mb-0">Jadwal</p>
        </a>
        <a href="{{ route('dokter.profile') }}" class="text-dark text-center">
            <i class="fas fa-user-md"></i>
            <p class="small mb-0">Profil</p>
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