@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Apoteker Dashboard</h1>

    <div class="row">
        <!-- Medications Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Obat</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $medicationsCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Total Obat Terdaftar</p>
                    <a href="{{ route('apoteker.obat.index') }}" class="btn btn-primary btn-sm">
                        Manage Obat
                    </a>
                </div>
            </div>
        </div>

        <!-- Prescriptions Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Resep Obat</h5>
                </div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $prescriptions ?? 'N/A' }}</h3>
                    <p class="text-muted">Total Resep Obat</p>
                    <a href="{{ route('apoteker.resep_obat.index') }}" class="btn btn-success btn-sm">
                        View Resep Obat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
