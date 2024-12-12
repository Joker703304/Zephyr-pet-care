{{-- @extends('layouts.app')

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
@endsection --}}


@extends('layouts.main')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pemilik Hewan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ownersCount ?? 'N/A' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paw fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Hewan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $animalsCount ?? 'N/A' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Dokter
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $doctorsCount ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Konsultasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $consultationsCount ?? 'N/A' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-notes-medical fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Obat Terdaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $medicationsCount ?? 'N/A' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-pills fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pemasukan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transactionsCount ?? 'N/A' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pasien Rawat Inap
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $inpatientCount ?? 'N/A' }}</div>
                            </div>
                            {{-- <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Antrian Sekarang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> {{ $nextQueue->no_antrian ?? 'Tidak Ada Antrian' }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>

    

    

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    {{-- <div class="row"> --}}

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Project Card Example -->
            {{-- <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Server Migration <span
                            class="float-right">20%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Sales Tracking <span
                            class="float-right">40%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Customer Database <span
                            class="float-right">60%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 60%"
                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Payout Details <span
                            class="float-right">80%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%"
                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Account Setup <span
                            class="float-right">Complete!</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div> --}}

            <!-- Color System -->
            {{-- <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card bg-primary text-white shadow">
                        <div class="card-body">
                            Primary
                            <div class="text-white-50 small">#4e73df</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-success text-white shadow">
                        <div class="card-body">
                            Success
                            <div class="text-white-50 small">#1cc88a</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-info text-white shadow">
                        <div class="card-body">
                            Info
                            <div class="text-white-50 small">#36b9cc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-warning text-white shadow">
                        <div class="card-body">
                            Warning
                            <div class="text-white-50 small">#f6c23e</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-danger text-white shadow">
                        <div class="card-body">
                            Danger
                            <div class="text-white-50 small">#e74a3b</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-secondary text-white shadow">
                        <div class="card-body">
                            Secondary
                            <div class="text-white-50 small">#858796</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-light text-black shadow">
                        <div class="card-body">
                            Light
                            <div class="text-black-50 small">#f8f9fc</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card bg-dark text-white shadow">
                        <div class="card-body">
                            Dark
                            <div class="text-white-50 small">#5a5c69</div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>

        <div class="col-lg-6 mb-4">

            <!-- Illustrations -->
            {{-- <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                            src="img/undraw_posting_photo.svg" alt="...">
                    </div>
                    <p>Add some quality, svg illustrations to your project courtesy of <a
                            target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                        constantly updated collection of beautiful svg images that you can use
                        completely free and without attribution!</p>
                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                        unDraw &rarr;</a>
                </div>
            </div> --}}

            <!-- Approach -->
            {{-- <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                </div>
                <div class="card-body">
                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                        CSS bloat and poor page performance. Custom CSS classes are used to create
                        custom components and custom utility classes.</p>
                    <p class="mb-0">Before working with this theme, you should become familiar with the
                        Bootstrap framework, especially the utility classes.</p>
                </div>
            </div> --}}

        </div>
    {{-- </div> --}}

</div>
<!-- /.container-fluid -->

@endsection