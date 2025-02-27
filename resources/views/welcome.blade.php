@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="hero-section text-center text-white py-5" style="background: linear-gradient(135deg, #3498db, #2ecc71); border-radius: 15px; padding: 60px 20px;">
        <h1 class="display-4 fw-bold">Selamat Datang di Zephyr Pet Care</h1>
        <p class="lead">Pelayanan terbaik untuk kesehatan dan kesejahteraan hewan kesayangan Anda.</p>
        
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2 px-4">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Daftar</a>
        </div>
    </div>

    <!-- Services Section -->
    <div class="services-section my-5">
        <h2 class="text-center mb-4 text-dark fw-bold">Layanan Kami</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-lg border-0 service-card text-center">
                    <div class="card-body">
                        <i class="fas fa-stethoscope fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Konsultasi Kesehatan</h5>
                        <p class="card-text text-muted">Dapatkan diagnosa dan perawatan terbaik dari dokter hewan profesional.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 service-card text-center">
                    <div class="card-body">
                        <i class="fas fa-list-ol fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Sistem Antrian</h5>
                        <p class="card-text text-muted">Dapatkan nomor antrian secara online dan pantau giliran Anda dengan mudah.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 service-card text-center">
                    <div class="card-body">
                        <i class="fas fa-pills fa-3x text-danger mb-3"></i>
                        <h5 class="card-title fw-bold">Farmasi Hewan</h5>
                        <p class="card-text text-muted">Obat-obatan lengkap sesuai resep dokter kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-section text-center text-white py-5 mt-5" style="background: linear-gradient(135deg, #8e44ad, #3498db); border-radius: 15px; padding: 50px 20px;">
        <h2 class="mb-4 fw-bold">Tentang Kami</h2>
        <p class="lead">Zephyr Pet Care adalah pusat layanan kesehatan hewan yang telah melayani masyarakat selama bertahun-tahun. Kami berkomitmen memberikan pelayanan terbaik untuk kesehatan dan kesejahteraan hewan kesayangan Anda.</p>
    </div>
</div>

<style>
    /* Efek hover dan animasi untuk card layanan */
    .service-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Responsif tombol di hero section */
    @media (max-width: 576px) {
        .hero-section .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
@endsection
