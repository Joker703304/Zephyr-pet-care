@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">kasir Dashboard</h1>

    <div class="row">
        <!-- Medications Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Daftar Ulang Hari ini</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $konsultasiCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Total Daftar Ulang</p>
                    <a href="{{ route('kasir.konsultasi.index') }}" class="btn btn-primary btn-sm">
                        Daftar Ulang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Antrian Hari ini</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{  $antrianCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Total Antrian</p>
                    <a href="{{ route('kasir.antrian.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua Antrian
                    </a>
                </div>
            </div>
        </div>

         

        <!-- Prescriptions Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Transaksi</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $counttransaksi ?? 'N/A' }}</h3>
                    <p class="text-muted">Total Belum Bayar Transaksi</p>
                    <a href="{{ route('kasir.transaksi.list') }}" class="btn btn-success btn-sm">
                        Lihat Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
