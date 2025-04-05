@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Dashboard Kasir</h3>
    </div>

    <div class="row g-4">
        <!-- Card: Daftar Ulang Hari Ini -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm text-white bg-primary border-0">
                <div class="card-body text-center py-4">
                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                    <h6 class="mb-1">Daftar Ulang Hari Ini</h6>
                    <h4>{{ $konsultasiCount ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Kelola daftar ulang konsultasi.</p>
                    <a href="{{ route('kasir.konsultasi.index') }}" class="btn btn-light btn-sm">Daftar Ulang</a>
                </div>
            </div>
        </div>

        <!-- Card: Transaksi Belum Dibayar -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm text-white bg-success border-0">
                <div class="card-body text-center py-4">
                    <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i>
                    <h6 class="mb-1">Transaksi Belum Dibayar</h6>
                    <h4>{{ $counttransaksi ?? 'N/A' }}</h4>
                    <p class="text-white-50 small">Lihat transaksi yang belum dibayar.</p>
                    <a href="{{ route('kasir.transaksi.list') }}" class="btn btn-light btn-sm">Lihat Transaksi</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="row mt-5">
        <!-- Grafik Daftar Ulang -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">Grafik Daftar Ulang (30 Hari)</div>
                <div class="card-body">
                    <canvas id="daftarUlangChart" height="400"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Transaksi -->
        <div class="col-12 col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">Grafik Transaksi (30 Hari)</div>
                <div class="card-body">
                    <canvas id="transaksiChart" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function () {
        const barOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                },
                x: {
                    ticks: {
                        maxRotation: 90,
                        minRotation: 45
                    }
                }
            }
        };

        // Grafik Daftar Ulang
        var ctxDaftarUlang = document.getElementById("daftarUlangChart").getContext("2d");
        new Chart(ctxDaftarUlang, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [
                    {
                        label: "Menunggu",
                        data: {!! json_encode($konsultasiCounts) !!},
                        backgroundColor: "#4e73df",
                        barThickness: 20
                    },
                    {
                        label: "Selesai",
                        data: {!! json_encode($konsultasiSelesaiCounts) !!},
                        backgroundColor: "#1cc88a",
                        barThickness: 20
                    }
                ]
            },
            options: barOptions
        });

        // Grafik Transaksi
        var ctxTransaksi = document.getElementById("transaksiChart").getContext("2d");
        new Chart(ctxTransaksi, {
            type: 'bar',
            data: {
                labels: {!! json_encode($dates) !!},
                datasets: [
                    {
                        label: "Sudah Dibayar",
                        data: {!! json_encode($sudahDibayarCounts) !!},
                        backgroundColor: "#1cc88a",
                        barThickness: 20
                    },
                    {
                        label: "Belum Dibayar",
                        data: {!! json_encode($belumDibayarCounts) !!},
                        backgroundColor: "#e74a3b",
                        barThickness: 20
                    }
                ]
            },
            options: barOptions
        });
    };
</script>

<style>
    .card-body canvas {
        width: 100% !important;
        max-height: 400px !important;
    }
</style>
@endsection
