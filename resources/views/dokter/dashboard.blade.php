@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Doctor Dashboard</h1>
    <div class="row">
        <!-- Medications Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Konsultasi Hari ini</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $medicationsCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Total Pasien Terdaftar</p>
                    <a href="{{ route('dokter.konsultasi.index') }}" class="btn btn-sm btn-primary">Lihat</a>
                </div>
            </div>
        </div>

        <!-- Prescriptions Card -->
        
    </div> 
</div>
@endsection
