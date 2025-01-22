@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dashboard Pemilik Hewan</h1>
    </div>
    <div class="row g-3">
        <!-- Card: Your Animals -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Hewan Peliharaan Anda</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $animalsCount ?? 'N/A' }}</h3>
                    <p class="text-mured">Lihat daftar hewan peliharaan anda yang telah terdaftar.</p>
                    <a href="{{ route('pemilik-hewan.hewan.index') }}" class="btn btn-primary btn-sm">Lihat Hewan</a>
                </div>
            </div>
        </div>

        <!-- Card: Consultations --> 
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5 class="card-title mb-0">Total Konsultasi</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $consultationsCount ?? 'N/A' }}</h3>
                    <p class="card-text">Lihat dan ajukan konsultasi hewan Anda.</p>
                    @if($pemilikHewan)
                        <a href="{{ route('pemilik-hewan.konsultasi_pemilik.index') }}" class="btn btn-warning btn-sm">Lihat Konsultasi</a>
                    @else
                        <a href="{{ route('pemilik-hewan.pemilik_hewan.create') }}" class="btn btn-secondary btn-sm">Isi Data</a>
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
                    <h3 class="display-6">{{ $prescriptions ?? 'N/A' }}</h3>
                    <p class="card-text">Lihat resep obat yang diberikan untuk hewan Anda.</p>
                    <a href="{{ route ('pemilik-hewan.resep_obat.index')}}" class="btn btn-warning btn-sm">Lihat Resep</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
