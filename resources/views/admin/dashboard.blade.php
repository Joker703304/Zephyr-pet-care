@extends('layouts.main')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        @php
            $cards = [
                ['title' => 'Total Pemilik Hewan', 'count' => $ownersCount ?? 'N/A', 'icon' => 'paw', 'color' => 'primary'],
                ['title' => 'Total Hewan', 'count' => $animalsCount ?? 'N/A', 'icon' => 'dog', 'color' => 'success'],
                ['title' => 'Total Dokter', 'count' => $doctorsCount ?? 'N/A', 'icon' => 'user-md', 'color' => 'info'],
                ['title' => 'Total Konsultasi', 'count' => $consultationsCount ?? 'N/A', 'icon' => 'notes-medical', 'color' => 'warning'],
                ['title' => 'Total Obat Terdaftar', 'count' => $medicationsCount ?? 'N/A', 'icon' => 'pills', 'color' => 'danger'],
                ['title' => 'Total Pemasukan Keseluruhan', 'count' => 'Rp'.number_format($totalEarnings ?? 0, 0, ',', '.'), 'icon' => 'dollar-sign', 'color' => 'success']
            ];
        @endphp
        
        @foreach($cards as $card)
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-{{ $card['color'] }} shadow h-100 py-2 card-hover">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $card['color'] }} text-uppercase mb-1">
                                {{ $card['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $card['count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-{{ $card['icon'] }} fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Bar Chart (Pemasukan Bulan Ini) -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pemasukan Bulan Ini</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="width: 100%; height: 350px;">
                        <canvas id="pemasukanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Clinic Data Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="width: 100%; height: 300px;">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   var ctxPemasukan = document.getElementById("pemasukanChart").getContext("2d");
    var pemasukanChart = new Chart(ctxPemasukan, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [
                {
                    label: "Pemasukan Bulanan",
                    data: {!! json_encode($monthlyEarnings) !!},
                    backgroundColor: "rgba(78, 115, 223, 0.7)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    borderWidth: 1
                },
                {
                    label: "Total Pemasukan Keseluruhan",
                    data: {!! json_encode(array_fill(0, count($monthlyLabels), $totalEarnings)) !!},
                    backgroundColor: "rgba(28, 200, 138, 0.7)",
                    borderColor: "rgba(28, 200, 138, 1)",
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    var ctxPie = document.getElementById("myPieChart").getContext("2d");
    var myPieChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ["Pemilik Hewan", "Hewan", "Dokter", "Konsultasi", "Obat"],
            datasets: [{
                data: [{{ $ownersCount }}, {{ $animalsCount }}, {{ $doctorsCount }}, {{ $consultationsCount }}, {{ $medicationsCount }}],
                backgroundColor: ["#4e73df", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b"],
                hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf", "#f4b619", "#c0392b"],
                hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

<style>
    .card-hover:hover {
        transform: scale(1.05);
        transition: 0.3s ease-in-out;
    }
</style>
@endsection
