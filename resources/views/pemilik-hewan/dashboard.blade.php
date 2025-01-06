@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Pemilik Hewan</h1>
    <div class="row g-3">
        <!-- Card: Your Animals -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Hewan Peliharaan Anda</h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Lihat daftar hewan peliharaan yang telah terdaftar.</p>
                    <a href="{{ route('pemilik-hewan.hewan.index') }}" class="btn btn-primary btn-sm">Lihat Hewan</a>
                </div>
            </div>
        </div>

        <!-- Card: Your Data -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">Data Anda</h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Kelola informasi data diri Anda.</p>
                    @if($pemilikHewan)
                        <a href="{{ route('pemilik-hewan.pemilik_hewan.index') }}" class="btn btn-secondary btn-sm">Lihat Data Diri</a>
                    @else
                        <a href="{{ route('pemilik-hewan.pemilik_hewan.create') }}" class="btn btn-secondary btn-sm">Isi Data</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card: Consultations -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Konsultasi</h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Lihat dan kelola riwayat konsultasi Anda.</p>
                    @if($pemilikHewan)
                    <a href="{{ route ('pemilik-hewan.konsultasi_pemilik.index')}}" class="btn btn-success btn-sm">Lihat Konsultasi</a>
                    @else
                        <a href="{{ route('pemilik-hewan.pemilik_hewan.create') }}" class="btn btn-secondary btn-sm">Lihat Konsultasi</a>
                    @endif
                    
                </div>
            </div>
        </div>

        <!-- Card: Prescriptions -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0">Resep Obat</h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">Lihat resep obat yang diberikan untuk hewan Anda.</p>
                    <a href="#" class="btn btn-warning btn-sm">Lihat Resep</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
