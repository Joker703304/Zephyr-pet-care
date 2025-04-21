@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="hero-section text-center text-white py-5" style="background: linear-gradient(135deg, #3498db, #2ecc71); border-radius: 15px; padding: 60px 20px;">
        <h1 class="display-4 fw-bold">Selamat Datang di Zephyr Pet Care</h1>
        <p class="lead">Pelayanan terbaik untuk kesehatan dan kesejahteraan hewan kesayangan Anda.</p>
        
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2 px-4">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Register</a>
        </div>
    </div>

    <!-- Services Section -->
    <div class="services-section my-5">
        <h2 class="text-center mb-4 text-dark fw-bold">Layanan Kami</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-lg border-0 service-card text-center">
                    <div class="card-body">
                        <i class="fas fa-stethoscope fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Konsultasi Kesehatan</h5>
                        <p class="card-text text-muted">Dapatkan diagnosa dan perawatan terbaik dari dokter hewan profesional.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 service-card text-center">
                    <div class="card-body">
                        <i class="fas fa-list-ol fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Sistem Antrian</h5>
                        <p class="card-text text-muted">Dapatkan nomor antrian secara online dan pantau giliran Anda dengan mudah.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-lg border-0 service-card text-center">
                    <div class="card-body">
                        <i class="fas fa-pills fa-3x text-danger mb-3"></i>
                        <h5 class="card-title fw-bold">Farmasi Hewan</h5>
                        <p class="card-text text-muted">Obat-obatan lengkap sesuai resep dokter kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="help-section my-5 p-4" style="background-color: #f8f9fa; border-radius: 15px;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold mb-3">Butuh Bantuan?</h2>
                <p class="text-muted">Kami menyediakan panduan lengkap untuk membantu Anda menggunakan layanan Zephyr Pet Care dengan mudah.</p>
                <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#helpModal">
                    <i class="fas fa-info-circle me-2"></i>Lihat Panduan Penggunaan
                </button>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-section text-center text-white py-5 mt-5" style="background: linear-gradient(135deg, #8e44ad, #3498db); border-radius: 15px; padding: 50px 20px;">
        <h2 class="mb-4 fw-bold">Tentang Kami</h2>
        <p class="lead">Zephyr Pet Care adalah pusat layanan kesehatan hewan yang telah melayani masyarakat selama bertahun-tahun. Kami berkomitmen memberikan pelayanan terbaik untuk kesehatan dan kesejahteraan hewan kesayangan Anda.</p>
    </div>
    
    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="helpModalLabel">Panduan Penggunaan Zephyr Pet Care</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="helpTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Alur Sistem</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="registration-tab" data-bs-toggle="tab" data-bs-target="#registration" type="button" role="tab" aria-controls="registration" aria-selected="false">Pendaftaran</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="consultation-tab" data-bs-toggle="tab" data-bs-target="#consultation" type="button" role="tab" aria-controls="consultation" aria-selected="false">Konsultasi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab" aria-controls="payment" aria-selected="false">Pembayaran</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" type="button" role="tab" aria-controls="faq" aria-selected="false">FAQ</button>
                            </li>
                        </ul>
                        
                        <!-- Tab content -->
                        <div class="tab-content p-3" id="helpTabContent">
                            <!-- Alur Sistem Tab -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                <h4 class="mb-3">Alur Kerja Sistem Zephyr Pet Care</h4> 
                                <div class="workflow-steps">
                                    <div class="step">
                                        <h5><span class="badge bg-primary">1</span> Pendaftaran</h5>
                                        <p>Daftar sebagai pengguna baru atau masuk dengan akun Anda. Kemudian, daftarkan data hewan peliharaan Anda ke dalam sistem.</p>
                                    </div>
                                    <div class="step">
                                        <h5><span class="badge bg-primary">2</span> Konsultasi</h5>
                                        <p>Buat permintaan konsultasi dengan memilih hewan, mengisi keluhan awal hewan peliharaan Anda, menentukan tangal, dan memilih dokter.</p>
                                    </div>
                                    <div class="step">
                                        <h5><span class="badge bg-primary">3</span> Pemeriksaan</h5>
                                        <p>Dokter akan memeriksa hewan peliharaan Anda dan memberikan diagnosis, layanan, serta resep obat jika diperlukan.</p>
                                    </div>
                                    <div class="step">
                                        <h5><span class="badge bg-primary">4</span> Pembayaran</h5>
                                        <p>Lakukan pembayaran untuk konsultasi, layanan, dan obat yang diresepkan melalui sistem pembayaran kami.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pendaftaran Tab -->
                            <div class="tab-pane fade" id="registration" role="tabpanel" aria-labelledby="registration-tab">
                                <h4>Panduan Pendaftaran</h4>
                                <p>Berikut adalah langkah-langkah untuk mendaftar dan menambahkan data hewan peliharaan Anda:</p>
                                
                                <div class="accordion" id="registrationAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Pendaftaran Akun
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#registrationAccordion">
                                            <div class="accordion-body">
                                                <ol>
                                                    <li>Klik tombol "Register" di halaman utama.</li>
                                                    <li>Isi formulir dengan data diri Anda.</li>
                                                    <li>Verifikasi akun melalui email yang dikirimkan.</li>
                                                    <li>Login dengan akun yang telah dibuat.</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Pendaftaran Hewan Peliharaan
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#registrationAccordion">
                                            <div class="accordion-body">
                                                <ol>
                                                    <li>Masuk ke dashboard pengguna.</li>
                                                    <li>Klik menu "Hewan Peliharaan".</li>
                                                    <li>Klik tombol "Tambah Hewan Peliharaan".</li>
                                                    <li>Isi data hewan peliharaan Anda.</li>
                                                    <li>Unggah foto hewan peliharaan (opsional).</li>
                                                    <li>Simpan data.</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Konsultasi Tab -->
                            <div class="tab-pane fade" id="consultation" role="tabpanel" aria-labelledby="consultation-tab">
                                <h4>Panduan Konsultasi</h4>
                                <p>Berikut adalah langkah-langkah untuk membuat dan mengelola konsultasi:</p>
                                
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Membuat Permintaan Konsultasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <ol>
                                            <li>Login ke akun Anda.</li>
                                            <li>Pilih menu "Konsultasi" di dashboard.</li>
                                            <li>Klik tombol "Ajukan Konsultasi".</li>
                                            <li>Pilih hewan peliharaan yang akan dikonsultasikan.</li>
                                            <li>Isi keluhan atau gejala yang dialami hewan.</li>
                                            <li>Tentukan jadwal yang diinginkan.</li>
                                            <li>Pilih dokter yang tersedia.</li>
                                            <li>Kirim permintaan konsultasi.</li>
                                        </ol>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Melacak Status Konsultasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Status konsultasi akan berubah sesuai dengan tahapan:</p>
                                        <ul>
                                            <li><span class="badge bg-warning text-dark">Menunggu</span> - Permintaan konsultasi sedang menunggu konfirmasi</li>
                                            <li><span class="badge bg-info">Diterima</span> - Konsultasi telah dikonfirmasi dan dijadwalkan</li>
                                            <li><span class="badge bg-primary">Sedang Perawatan</span> - Hewan peliharaan sedang ditangani oleh dokter</li>
                                            <li><span class="badge bg-primary">Pembuatan Obat</span> - Obat untuk hewan peliharaan sedang dipersiapkan</li>
                                            <li><span class="badge bg-success">Pembayaran</span> - Konsultasi selesai dan menunggu proses pembayaran</li>
                                            <li><span class="badge bg-danger">Dibatalkan</span> - Konsultasi telah dibatalkan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pembayaran Tab -->
                                <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                    <h4>Panduan Pembayaran</h4>
                                    <p>Berikut adalah alur proses pembayaran di Zephyr Pet Care:</p>
                                    
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title">Alur Proses Pembayaran</h5>
                                            <div class="payment-flow">
                                                <div class="step-box">
                                                    <div class="step-number">1</div>
                                                    <div class="step-content">
                                                        <h6>Konsultasi Selesai</h6>
                                                        <p>Setelah konsultasi dokter selesai, sistem akan menampilkan notifikasi "Konsultasi Selesai" yang menandakan proses pembayaran dapat dilakukan.</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="step-box">
                                                    <div class="step-number">2</div>
                                                    <div class="step-content">
                                                        <h6>Proses oleh Kasir</h6>
                                                        <p>Kasir akan melihat tagihan yang muncul pada sistem dan menginformasikan total biaya kepada Anda.</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="step-box">
                                                    <div class="step-number">3</div>
                                                    <div class="step-content">
                                                        <h6>Pembayaran Tunai</h6>
                                                        <p>Serahkan uang tunai kepada kasir sesuai dengan total biaya atau lebih.</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="step-box">
                                                    <div class="step-number">4</div>
                                                    <div class="step-content">
                                                        <h6>Verifikasi Pembayaran</h6>
                                                        <p>Kasir akan memasukkan jumlah uang yang Anda berikan ke dalam sistem:</p>
                                                        <ul>
                                                            <li>Jika uang yang diberikan kurang dari total tagihan, sistem akan menolak proses pembayaran</li>
                                                            <li>Jika uang yang diberikan lebih dari total tagihan, sistem akan menghitung kembalian</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                
                                                <div class="step-box">
                                                    <div class="step-number">5</div>
                                                    <div class="step-content">
                                                        <h6>Konfirmasi Pembayaran</h6>
                                                        <p>Kasir akan mengklik tombol "Bayar" untuk menyelesaikan transaksi.</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="step-box">
                                                    <div class="step-number">6</div>
                                                    <div class="step-content">
                                                        <h6>Cetak Struk</h6>
                                                        <p>Sistem akan menampilkan struk elektronik dan mencetak bukti pembayaran untuk Anda.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-header bg-light">
                                                    <h5 class="mb-0">Informasi Tagihan</h5>
                                                </div>
                                                <div class="card-body">
                                                    <p>Tagihan Anda akan mencakup:</p>
                                                    <ul>
                                                        <li>Biaya konsultasi dokter</li>
                                                        <li>Biaya obat-obatan (jika diresepkan)</li>
                                                        <li>Biaya layanan tambahan (jika ada)</li>
                                                    </ul>
                                                    <p class="alert alert-info">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Semua biaya akan ditampilkan secara transparan pada struk pembayaran.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="card h-100">
                                                <div class="card-header bg-light">
                                                    <h5 class="mb-0">Bukti Pembayaran</h5>
                                                </div>
                                                <div class="card-body">
                                                    <p>Setelah pembayaran selesai, Anda akan mendapatkan:</p>
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="me-3">
                                                            <i class="fas fa-receipt fa-2x text-success"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Struk Fisik</h6>
                                                            <p class="mb-0 small text-muted">Dicetak oleh kasir sebagai bukti pembayaran resmi</p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <i class="fas fa-envelope fa-2x text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">Riwayat Digital</h6>
                                                            <p class="mb-0 small text-muted">Tersimpan di akun Anda dan dapat diakses kapan saja</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Demo Visual Alur Pembayaran</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="border rounded p-3">
                                                        <div class="demo-img mb-2 bg-light" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-clipboard-check fa-3x text-success"></i>
                                                        </div>
                                                        <h6>1. Tampilan Notifikasi Konsultasi Selesai</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="border rounded p-3">
                                                        <div class="demo-img mb-2 bg-light" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-calculator fa-3x text-primary"></i>
                                                        </div>
                                                        <h6>2. Tampilan Input Pembayaran</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="border rounded p-3">
                                                        <div class="demo-img mb-2 bg-light" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-file-invoice-dollar fa-3x text-info"></i>
                                                        </div>
                                                        <h6>3. Tampilan Struk Pembayaran</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <!-- FAQ Tab -->
                            <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                                <h4>Pertanyaan yang Sering Diajukan</h4>
                                
                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faqHeadingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                                                Bagaimana cara membatalkan konsultasi?
                                            </button>
                                        </h2>
                                        <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Untuk membatalkan konsultasi, masuk ke dashboard Anda, pilih menu "Konsultasi", temukan konsultasi yang ingin dibatalkan, dan klik tombol "Batalkan".
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faqHeadingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                                                Bagaimana cara mengubah data hewan peliharaan?
                                            </button>
                                        </h2>
                                        <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Masuk ke dashboard Anda, pilih menu "Hewan Peliharaan", temukan data hewan yang ingin diubah, dan klik data hewan yang ingin di edit. Setelah mengubah data, klik "Update Hewan" untuk menyimpan perubahan.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faqHeadingThree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                                                Bagaimana cara melihat riwayat medis hewan peliharaan?
                                            </button>
                                        </h2>
                                        <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Masuk ke dashboard Anda, pilih menu "Riwayat Hewan", pilih hewan yang ingin dilihat riwayat medisnya, kemudian klik tab "Riwayat Medis". Di sana Anda akan menemukan semua catatan konsultasi dan pengobatan sebelumnya.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faqHeadingFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
                                                Bagaimana mendapatkan nomor antrian?
                                            </button>
                                        </h2>
                                        <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                Setelah mengajukan konsultasi, kasir mendaftar ulang dan kita mendapatkan no antrian.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Efek hover dan animasi untuk card layanan */
    .service-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Responsif tombol di hero section */
    @media (max-width: 576px) {
        .hero-section .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }
    
    /* Styling untuk workflow steps */
    .workflow-steps .step {
        padding: 15px;
        border-left: 3px solid #3498db;
        margin-bottom: 20px;
        background-color: #f8f9fa;
        border-radius: 0 10px 10px 0;
    }
    
    /* Styling untuk bantuan floating button */
    .floating-help-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #3498db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
    
    .floating-help-btn:hover {
        transform: scale(1.1);
        background: #2980b9;
    }
</style>

<!-- Tombol bantuan mengambang -->
<div class="floating-help-btn" data-bs-toggle="modal" data-bs-target="#helpModal">
    <i class="fas fa-question-circle fa-2x"></i>
</div>
@endsection