@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Dashboard Apoteker</h3>
    </div>

    <div class="row g-3">
        <!-- Card: Total Obat -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-primary border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-capsules fa-2x mb-2"></i>
                    <h6>Total Obat</h6>
                    <h4>{{ $medicationsCount ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Kelola dan stok obat yang tersedia.</p>
                    <a href="{{ route('apoteker.obat.index') }}" class="btn btn-light btn-sm">Kelola Obat</a>
                </div>
            </div>
        </div>

        <!-- Card: Resep Obat -->
        <div class="col-md-6 col-lg-6">
            <div class="card shadow-sm text-white bg-danger border-0">
                <div class="card-body text-center py-3">
                    <i class="fas fa-prescription-bottle-alt fa-2x mb-2"></i>
                    <h6>Total Resep Obat</h6>
                    <h4>{{ $prescriptions ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Lihat dan proses resep obat.</p>
                    <a href="{{ route('apoteker.resep_obat.index') }}" class="btn btn-light btn-sm">Lihat Resep</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mt-4">
        <!-- Grafik Stok Obat -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Stok Obat</div>
                <div class="card-body">
                    <canvas id="stokObatChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Resep Obat -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">Distribusi Resep Obat</div>
                <div class="card-body">
                    <canvas id="resepObatChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Navbar for Mobile -->
<nav class="mobile-nav d-md-none fixed-bottom bg-white shadow py-2">
    <div class="container d-flex justify-content-around">
        <a href="{{ route('apoteker.obat.index') }}" class="text-dark text-center">
            <i class="fas fa-capsules"></i>
            <p class="small mb-0">Obat</p>
        </a>
        <a href="{{ route('apoteker.resep_obat.index') }}" class="text-dark text-center">
            <i class="fas fa-prescription-bottle-alt"></i>
            <p class="small mb-0">Resep</p>
        </a>
        <a href="{{ route('apoteker.profile') }}" class="text-dark text-center">
            <i class="fas fa-user-md"></i>
            <p class="small mb-0">Profil</p>
        </a>
    </div>
</nav>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Atur tinggi elemen canvas agar kedua grafik memiliki ukuran yang sama
document.getElementById("stokObatChart").parentElement.style.height = "300px";
document.getElementById("resepObatChart").parentElement.style.height = "300px";
    // Grafik Stok Obat
var ctxObat = document.getElementById("stokObatChart").getContext("2d");
var stokObatChart = new Chart(ctxObat, {
    type: 'bar',
    data: {
        labels: {!! json_encode($medicineNames) !!},
        datasets: [{
            label: "Stok Obat",
            data: {!! json_encode($medicineStock) !!},
            backgroundColor: [
                "#4e73df", "#1cc88a", "#f6c23e", "#e74a3b", "#36b9cc"
            ],
            borderColor: "#fff",
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return "Stok: " + tooltipItem.raw + " unit";
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value + " unit";
                    }
                }
            }
        }
    }
});

// Grafik Distribusi Resep Obat
var ctxResep = document.getElementById("resepObatChart").getContext("2d");
var resepObatChart = new Chart(ctxResep, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($prescriptionCategories) !!},
        datasets: [{
            data: {!! json_encode($prescriptionCounts) !!},
            backgroundColor: [
                "#4e73df", "#1cc88a", "#f6c23e", "#e74a3b", "#36b9cc"
            ],
            hoverBackgroundColor: [
                "#2e59d9", "#17a673", "#f4b619", "#c0392b", "#2c9faf"
            ],
            hoverBorderColor: "#fff"
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
            animateRotate: true,
            animateScale: true
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ": " + tooltipItem.raw + " resep";
                    }
                }
            }
        }
    }
});
</script>

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