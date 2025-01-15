@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajukan Konsultasi</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pemilik-hewan.konsultasi_pemilik.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="id_hewan">Pilih Hewan</label>
            <select name="id_hewan" id="id_hewan" class="form-control" required>
                <option value="">Pilih Hewan</option>
                @foreach($hewan as $h)
                    <option value="{{ $h->id_hewan }}">{{ $h->nama_hewan }} ({{ $h->jenis }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="keluhan">Keluhan</label>
            <textarea name="keluhan" id="keluhan" class="form-control" rows="3" required>{{ old('keluhan') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="tanggal_konsultasi">Tanggal Konsultasi</label>
            <input type="text" name="tanggal_konsultasi" id="tanggal_konsultasi" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="dokter">Pilih Dokter</label>
            <select name="dokter_id" id="dokter" class="form-control" required>
                <option value="">Pilih Dokter</option>
                @foreach($dokterJadwal as $jadwal)
                    <option value="{{ $jadwal->dokter->id_dokter }}">
                        {{ $jadwal->dokter->user->name }} (Maksimal Konsultasi: {{ $jadwal->maksimal_konsultasi }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Konsultasi</button>
        <a href="{{ route('pemilik-hewan.konsultasi_pemilik.index') }}" class="btn btn-secondary btn-primary">Kembali</a>
    </form>
</div>

<!-- Flatpickr Styles and Script -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
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
    /* Custom style untuk dropdown dokter supaya bisa scroll */
    #dokter {
        max-height: 200px; /* Tentukan tinggi maksimal dropdown */
        overflow-y: auto;  /* Tambahkan scroll jika lebih banyak opsi */
    }
</style>

@endsection
