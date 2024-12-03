@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Admin Dashboard</h1>
    
    <!-- First Row -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center">Total Users</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $usersCount }}</h3>
                    <p class="text-muted">Total registered users.</p>
                    <a href="{{ route('admin.user') }}" class="btn btn-sm btn-success">Manage Users</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white text-center">Total Animals</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $animalsCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Total animals registered.</p>
                    <a href="/hewan/index" class="btn btn-sm btn-info">Manage Animals</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-white text-center">Total Doctors</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $doctorsCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Total doctors in the clinic.</p>
                    <a href="/dokter/index" class="btn btn-sm btn-warning">Manage Doctors</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">Animal Owners</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $ownersCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Total animal owners.</p>
                    <a href="/pemilik_hewan/index" class="btn btn-sm btn-primary">Manage Owners</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-danger text-white text-center">Total Consultations</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $consultationsCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Consultations conducted.</p>
                    <a href="/konsultasi/index" class="btn btn-sm btn-danger">View Consultations</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-secondary text-white text-center">Total Medications</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $medicationsCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Medications available.</p>
                    <a href="/obat/index" class="btn btn-sm btn-secondary">Manage Medications</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Row -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-light text-dark text-center">Total Diagnoses</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $diagnosesCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Diagnoses recorded.</p>
                    <a href="/diagnosis/index" class="btn btn-sm btn-light">View Diagnoses</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white text-center">Queue Management</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $queueCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Patients in queue.</p>
                    <a href="/antrian/index" class="btn btn-sm btn-dark">Manage Queue</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center">Medical Prescriptions</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $treatedAnimalsCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Total drug Prescription.</p>
                    <a href="/resep/index" class="btn btn-sm btn-success">View Medical Prescriptions</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Fourth Row -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-danger text-white text-center">Inpatient Care</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $inpatientCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Animals receiving care.</p>
                    <a href="/rawat_inap/index" class="btn btn-sm btn-danger">View Inpatient Care</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-secondary text-white text-center">Financial Transactions</div>
                <div class="card-body text-center">
                    <h3 class="display-6">{{ $transactionsCount ?? 'N/A' }}</h3>
                    <p class="text-muted">Transactions processed.</p>
                    <a href="/transaksi/index" class="btn btn-sm btn-secondary">Manage Transactions</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
