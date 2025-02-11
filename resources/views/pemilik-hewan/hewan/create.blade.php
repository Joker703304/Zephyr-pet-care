@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card untuk Create Hewan -->
    <div class="card">
        <div class="card-header">
            <h1>Tambah Hewan</h1>
        </div>

        <div class="card-body">
            <form action="{{ route('pemilik-hewan.hewan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Hidden field for id_pemilik -->
                <input type="hidden" name="id_pemilik" value="{{ $pemilikId }}">

                <!-- Nama Hewan -->
                <div class="form-group mb-3">
                    <label for="nama_hewan">
                        <i class="fas fa-paw"></i> Nama Hewan
                    </label>
                    <input type="text" name="nama_hewan" id="nama_hewan" class="form-control" value="{{ old('nama_hewan') }}" required>
                    <small class="form-text text-muted">Masukkan nama hewan yang akan didaftarkan.</small>
                </div>

                <!-- Jenis Hewan -->
                <div class="form-group mb-3">
                    <label for="jenis_id">
                        <i class="fas fa-paw"></i> Jenis Hewan
                    </label>
                    <select name="jenis_id" id="jenis_id" class="form-control" required>
                        <option value="">Pilih Jenis Hewan</option>
                        @foreach($jenisHewan as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Pilih jenis hewan sesuai dengan yang Anda miliki.</small>
                </div>

                <!-- Jenis Kelamin -->
                <div class="form-group mb-3">
                    <label for="jenkel">
                        <i class="fas fa-venus-mars"></i> Jenis Kelamin
                    </label>
                    <select name="jenkel" id="jenkel" class="form-control" required>
                        <option value="" selected>Pilih Jenis Kelamin</option> <!-- Opsi default -->
                        <option value="jantan" {{ old('jenkel') == 'jantan' ? 'selected' : '' }}>Jantan</option>
                        <option value="betina" {{ old('jenkel') == 'betina' ? 'selected' : '' }}>Betina</option>
                    </select>
                    <small class="form-text text-muted">Pilih jenis kelamin hewan.</small>
                </div>

                <!-- Umur -->
                <div class="form-group mb-3">
                    <label for="umur">
                        <i class="fas fa-calendar-alt"></i> Umur (Bulan)
                    </label>
                    <input type="number" name="umur" id="umur" class="form-control" value="{{ old('umur') }}" min="0" required>
                    <small class="form-text text-muted">Masukkan umur hewan dalam bulan.</small>
                </div>

                <!-- Berat -->
                <div class="form-group mb-3">
                    <label for="berat">
                        <i class="fas fa-weight-hanging"></i> Berat (Gram)
                    </label>
                    <input type="number" step="0.01" name="berat" id="berat" class="form-control" value="{{ old('berat') }}" required>
                    <small class="form-text text-muted">Masukkan berat hewan dalam gram.</small>
                </div>

                <!-- Foto Hewan -->
                <div class="form-group mb-3">
                    <label for="foto">
                        <i class="fas fa-camera"></i> Foto Hewan (maks: 2MB)
                    </label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    <small class="form-text text-muted">Unggah foto hewan Anda (maksimal 2MB).</small>
                </div>

                <!-- Tombol Submit -->
                <div class="d-flex gap-2">
                    <a href="{{ route('pemilik-hewan.hewan.index') }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-success mb-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk memblokir input karakter negatif
    function blockNegativeInput(event) {
        if (event.key === '-' || event.key === 'e' || event.key === 'E') {
            event.preventDefault(); // Blokir karakter yang tidak diizinkan
        }
    }

    // Terapkan fungsi pada input Umur dan Berat
    document.getElementById('umur').addEventListener('keydown', blockNegativeInput);
    document.getElementById('berat').addEventListener('keydown', blockNegativeInput);

    // Pastikan nilai tetap positif meskipun ada input paste
    document.getElementById('umur').addEventListener('input', function (e) {
        if (e.target.value < 0) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        }
    });
    document.getElementById('berat').addEventListener('input', function (e) {
        if (e.target.value < 0) {
            e.target.value = e.target.value.replace(/[^0-9.]/g, '');
        }
    });
</script>
@endsection