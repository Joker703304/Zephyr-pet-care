@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">🩺 Ajukan Konsultasi</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-lg p-4">
        <form action="{{ route('pemilik-hewan.konsultasi_pemilik.store') }}" method="POST" id="konsultasiForm">
            @csrf

            <div class="mb-3">
                <label for="id_hewan" class="form-label fw-bold"><i class="fas fa-paw"></i> Pilih Hewan</label>
                <select name="id_hewan" id="id_hewan" class="form-control" required>
                    <option value="">Pilih Hewan</option>
                    @foreach($hewan as $h)
                        <option value="{{ $h->id_hewan }}">{{ $h->nama_hewan }} ({{ $h->jenis->nama_jenis }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="keluhan" class="form-label fw-bold"><i class="fas fa-exclamation-triangle"></i> Keluhan</label>
                <textarea name="keluhan" id="keluhan" class="form-control" rows="3" required placeholder="Jelaskan keluhan hewan peliharaan Anda...">{{ old('keluhan') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="tanggal_konsultasi" class="form-label fw-bold"><i class="fas fa-calendar-alt"></i> Tanggal Konsultasi</label>
                <input type="text" name="tanggal_konsultasi" id="tanggal_konsultasi" class="form-control" required placeholder="Pilih tanggal...">
            </div>

            <div class="mb-3">
                <label for="dokter" class="form-label fw-bold"><i class="fas fa-user-md"></i> Pilih Dokter</label>
                <select name="dokter_id" id="dokter" class="form-control" required>
                    <option value="">Pilih Dokter</option>
                    @foreach($dokterJadwal as $jadwal)
                        <option value="{{ $jadwal->dokter->id_dokter }}">
                            {{ $jadwal->dokter->user->name }} (Maksimal Konsultasi: {{ $jadwal->maksimal_konsultasi }})
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('pemilik-hewan.konsultasi_pemilik.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary" id="submitButton">Ajukan Konsultasi</button>
        </form>
    </div>
</div>

<!-- Flatpickr Styles and Script -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.querySelector('#konsultasiForm').addEventListener('submit', function() {
        const button = document.getElementById('submitButton');
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengajukan...';
    });

    // Jadwal dokter dari backend
    const dokterJadwal = @json($dokterJadwal);

    // Dropdown dokter dan input tanggal
    const dokterSelect = document.getElementById('dokter');
    const tanggalInput = document.getElementById('tanggal_konsultasi');

    // Buat array tanggal praktik dokter
    const datesWithDoctors = dokterJadwal
        .filter(jadwal => jadwal.status === 'praktik')
        .map(jadwal => jadwal.tanggal);

    // Inisialisasi Flatpickr
    flatpickr(tanggalInput, {
        dateFormat: "Y-m-d",
        minDate: "today", // Disable hari kemarin
        onChange: function(selectedDates, dateStr) {
            const selectedDate = dateStr;
            const availableDoctors = dokterJadwal.filter(jadwal => jadwal.tanggal === selectedDate && jadwal.maksimal_konsultasi !== null);

            // Reset dropdown dokter
            dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';
            
            // Enable the doctor dropdown after a valid date is selected
            dokterSelect.disabled = false;

            // Jika ada dokter yang tersedia
            if (availableDoctors.length > 0) {
                availableDoctors.forEach(jadwal => {
                    const option = document.createElement('option');
                    option.value = jadwal.id_dokter;

                    // Jika kuota konsultasi sudah habis
                    if (jadwal.maksimal_konsultasi === 0) {
                        option.textContent = `${jadwal.dokter.user.name} (Kuota Konsultasi Telah Habis)`;
                        option.disabled = true; // Nonaktifkan opsi ini
                    } else {
                        option.textContent = `${jadwal.dokter.user.name} (Maksimal Konsultasi: ${jadwal.maksimal_konsultasi})`;
                    }

                    dokterSelect.appendChild(option);
                });
            } else {
                // Jika tidak ada dokter yang tersedia
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Tidak ada dokter yang tersedia pada tanggal ini';
                dokterSelect.appendChild(option);
            }
        },
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const date = dayElem.getAttribute("aria-label");

            // Jika ada dokter praktik di tanggal tersebut, beri warna hijau
            if (datesWithDoctors.includes(date)) {
                dayElem.style.backgroundColor = "green";
                dayElem.style.color = "white";
            }
        }
    });

    // Disable the dokter select initially
    dokterSelect.disabled = true;
</script>

<style>
    .card {
        border-radius: 12px;
        max-width: 600px;
        margin: auto;
    }

    .form-control {
        border-radius: 8px;
    }

    .btn {
        border-radius: 8px;
    }

    @media (max-width: 576px) {
        h1 {
            font-size: 22px;
        }

        .form-label {
            font-size: 14px;
        }

        .btn {
            font-size: 14px;
            padding: 8px 12px;
        }
    }
</style>
@endsection
