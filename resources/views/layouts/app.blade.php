<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Sembunyikan navbar di mobile */
        @media (max-width: 768px) {
            .desktop-header {
                display: none;
            }
        }
        
        /* Pastikan bottom navbar tidak menutupi konten */
        body {
            padding-bottom: 60px;
        }

        .mobile-nav {
            border-top: 1px solid #ddd;
        }
        
        .mobile-nav a {
            text-decoration: none;
            flex-grow: 1;
            padding: 10px 0;
            color: #333;
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
</head>

<body>
    <div id="app">
        <!-- Navbar (Hanya muncul di Desktop) -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Brand -->
                @php
                    $userRole = auth()->check() ? auth()->user()->role : null;
                    $dashboardRoutes = [
                        'pemilik_hewan' => 'pemilik-hewan.dashboard',
                        'dokter' => 'dokter.dashboard',
                        'apoteker' => 'apoteker.dashboard',
                        'kasir' => 'kasir.dashboard',
                        'security' => 'security.dashboard',
                    ];
                @endphp
        
                <a class="navbar-brand fw-bold" href="{{ auth()->check() && isset($dashboardRoutes[$userRole]) ? route($dashboardRoutes[$userRole]) : url('/') }}">
                    <i class="fas fa-paw"></i> Zephyr Pet
                </a>
        
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                            </li>
                        @else
                            @if ($userRole !== 'security')
                                <!-- Dropdown Menu untuk Navigasi Dashboard (Security tidak memiliki menu ini) -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bars"></i> Menu
                                    </a>
        
                                    <div class="dropdown-menu">
                                        @if ($userRole === 'dokter')
                                            <a class="dropdown-item" href="{{ route('dokter.jadwal.dokter') }}">
                                                <i class="fas fa-calendar-alt"></i> Jadwal Saya
                                            </a>
                                            <a class="dropdown-item" href="{{ route('dokter.konsultasi.index') }}">
                                                <i class="fas fa-stethoscope"></i> Konsultasi
                                            </a>
                                        @endif
        
                                        @if ($userRole === 'pemilik_hewan')
                                            <a class="dropdown-item" href="{{ route('pemilik-hewan.hewan.index') }}">
                                                <i class="fas fa-dog"></i> Hewan Peliharaan
                                            </a>
                                            <a class="dropdown-item" href="{{ route('pemilik-hewan.konsultasi_pemilik.index') }}">
                                                <i class="fas fa-comments-medical"></i> Konsultasi
                                            </a>
                                            <a class="dropdown-item" href="{{ route('pemilik-hewan.resep_obat.index') }}">
                                                <i class="fas fa-pills"></i> Resep Obat
                                            </a>
                                            <a class="dropdown-item" href="{{ route('pemilik-hewan.transaksi.list') }}">
                                                <i class="fas fa-receipt"></i> Riwayat Transaksi
                                            </a>
                                        @endif
        
                                        @if ($userRole === 'kasir')
                                            <a class="dropdown-item" href="{{ route('kasir.konsultasi.index') }}">
                                                <i class="fas fa-clipboard-list"></i> Daftar Ulang
                                            </a>
                                            <a class="dropdown-item" href="{{ route('kasir.transaksi.list') }}">
                                                <i class="fas fa-cash-register"></i> Transaksi
                                            </a>
                                        @endif
        
                                        @if ($userRole === 'apoteker')
                                            <a class="dropdown-item" href="{{ route('apoteker.obat.index') }}">
                                                <i class="fas fa-capsules"></i> Kelola Obat
                                            </a>
                                            <a class="dropdown-item" href="{{ route('apoteker.resep_obat.index') }}">
                                                <i class="fas fa-file-medical"></i> Kelola Resep Obat
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endif
        
                            <!-- Dropdown Menu untuk Profile & Logout -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                </a>
        
                                <div class="dropdown-menu dropdown-menu-end">
                                    @php
                                        $profileRoutes = [
                                            'pemilik_hewan' => 'pemilik-hewan.pemilik_hewan.index',
                                            'dokter' => 'dokter.profile',
                                            'apoteker' => 'apoteker.profile',
                                            'kasir' => 'kasir.profile',
                                            'security' => 'security.profile',
                                        ];
                                    @endphp
        
                                    @if (isset($profileRoutes[$userRole]))
                                        <a class="dropdown-item" href="{{ route($profileRoutes[$userRole]) }}">
                                            <i class="fas fa-user"></i> Profil
                                        </a>
                                    @endif
        
                                    <div class="dropdown-divider"></div>
        
                                    <!-- Logout -->
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
        
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>                              

        <main class="py-4">
            @yield('content')
        </main>

<!-- Bottom Navbar for Mobile -->
@if (auth()->check())
<nav class="mobile-nav d-md-none fixed-bottom bg-white shadow py-2">
    <div class="container d-flex justify-content-around">
        @php
            // Cek apakah pengguna sudah melengkapi profil
            $profilLengkap = auth()->user()->pemilikHewan; 
        @endphp

        @if (auth()->user()->role === 'pemilik_hewan')
            <a href="{{ $profilLengkap ? route('pemilik-hewan.hewan.index') : '#' }}" 
               class="text-dark text-center {{ $profilLengkap ? '' : 'disabled-menu' }}">
                <i class="fas fa-paw"></i>
                <p class="small mb-0">Hewan</p>
            </a>

            <a href="{{ $profilLengkap ? route('pemilik-hewan.konsultasi_pemilik.index') : '#' }}" 
               class="text-dark text-center {{ $profilLengkap ? '' : 'disabled-menu' }}">
                <i class="fas fa-comments"></i>
                <p class="small mb-0">Konsultasi</p>
            </a>

            <a href="{{ $profilLengkap ? route('pemilik-hewan.resep_obat.index') : '#' }}" 
               class="text-dark text-center {{ $profilLengkap ? '' : 'disabled-menu' }}">
                <i class="fas fa-prescription-bottle-alt"></i>
                <p class="small mb-0">Resep</p>
            </a>

            <a href="{{ $profilLengkap ? route('pemilik-hewan.transaksi.list') : '#' }}" 
               class="text-dark text-center {{ $profilLengkap ? '' : 'disabled-menu' }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <p class="small mb-0">Transaksi</p>
            </a>

            <a href="{{ $profilLengkap ? route('pemilik-hewan.pemilik_hewan.index') : '#' }}" 
               class="text-dark text-center {{ $profilLengkap ? '' : 'disabled-menu' }}">
                <i class="fas fa-user"></i>
                <p class="small mb-0">Profil</p>
            </a>

        @elseif (auth()->user()->role === 'dokter')
            <a href="{{ route('dokter.konsultasi.index') }}" class="text-dark text-center">
                <i class="fas fa-stethoscope"></i>
                <p class="small mb-0">Konsultasi</p>
            </a>
            <a href="{{ route('dokter.jadwal.dokter') }}" class="text-dark text-center">
                <i class="fas fa-calendar-check"></i>
                <p class="small mb-0">Jadwal</p>
            </a>
            <a href="{{ route('dokter.profile') }}" class="text-dark text-center">
                <i class="fas fa-user"></i>
                <p class="small mb-0">Profil</p>
            </a>

        @elseif (auth()->user()->role === 'apoteker')
            <a href="{{ route('apoteker.obat.index') }}" class="text-dark text-center">
                <i class="fas fa-capsules"></i>
                <p class="small mb-0">Obat</p>
            </a>

            <a href="{{ route('apoteker.resep_obat.index') }}" class="text-dark text-center">
                <i class="fas fa-prescription-bottle-alt"></i>
                <p class="small mb-0">Resep</p>
            </a>

            <a href="{{ route('apoteker.profile') }}" class="text-dark text-center">
                <i class="fas fa-user"></i>
                <p class="small mb-0">Profil</p>
            </a>
        @endif

        <!-- Menu Logout untuk Semua Role -->
        <a href="{{ route('logout') }}" class="text-dark text-center"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <p class="small mb-0">Logout</p>
        </a>
    </div>
</nav>

<!-- Form Logout -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endif

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
.disabled-menu {
        pointer-events: none;
        opacity: 0.5;
}
</style>
    </div>
</body>
</html>