@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Form Diagnosis</h1>

    {{-- Informasi Konsultasi --}}
    <div class="card mb-3">
        <div class="card-header">Informasi Konsultasi</div>
        <div class="card-body">
            <p><strong>No Antrian:</strong> {{ $konsultasi->no_antrian }}</p>
            <p><strong>Nama Hewan:</strong> {{ $konsultasi->hewan->nama_hewan }}</p>
            <p><strong>Keluhan:</strong> {{ $konsultasi->keluhan }}</p>
            <p><strong>Tanggal Konsultasi:</strong> {{ $konsultasi->tanggal_konsultasi }}</p>
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('dokter.konsultasi.storeDiagnosis', $konsultasi->id_konsultasi) }}" method="POST">
        @csrf
        @method('POST')

        {{-- Diagnosis --}}
        <div class="form-group">
            <label for="diagnosis">Diagnosis</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" required>{{ old('diagnosis', $konsultasi->diagnosis) }}</textarea>
        </div>

        {{-- Layanan Dropdown --}}
        <h5>Layanan</h5>
        <div id="layanan-container">
            @foreach ($konsultasi->layanan as $index => $layanan)
                <div class="form-group mt-3 d-flex align-items-center" id="layanan-field-{{ $layanan->id_layanan }}">
                    <div class="w-100">
                        <select name="layanan_id[{{ $layanan->id_layanan }}]" class="form-control" required>
                            @foreach ($layanan as $item)
                                <option value="{{ $item->id_layanan }}" {{ in_array($item->id_layanan, old('layanan_id', $konsultasi->layanan->pluck('id_layanan')->toArray() ?? [])) ? 'selected' : '' }}>
                                    {{ $item->nama_layanan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger ml-2" onclick="removeLayananField('{{ $layanan->id_layanan }}')">Hapus</button>
                </div>
            @endforeach
        </div>
        <button type="button" id="add-layanan" class="btn btn-secondary mt-3">Tambah Layanan</button>

        {{-- Resep Obat --}}
        <h5>Resep Obat</h5>
        <div id="resep-obat-container">
            @foreach ($konsultasi->resepObat as $index => $resep)
                <div class="form-group mt-3 d-flex align-items-center" id="obat-field-{{ $resep->id_resep }}">
                    <div class="w-100">
                        <select name="obat[{{ $resep->id_resep }}][id_obat]" class="form-control obat-select" required {{ $resep->id_obat ? 'disabled' : '' }}>
                            <option value="" disabled selected>Pilih Obat</option>
                            @foreach ($obat as $item)
                                <option value="{{ $item->id_obat }}" {{ $resep->id_obat == $item->id_obat ? 'selected' : '' }}>
                                    {{ $item->nama_obat }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="obat[{{ $resep->id_resep }}][jumlah]" class="form-control mt-2" value="{{ $resep->jumlah }}" required {{ $resep->id_obat ? 'disabled' : '' }}>
                    </div>
                    <button type="button" class="btn btn-danger ml-2" onclick="removeObatField('{{ $resep->id_resep }}')">Hapus</button>
                </div>
            @endforeach
        </div>
        <input type="hidden" name="deleted_obat_ids" id="deleted-obat-ids" value="">

        <button type="button" id="add-obat" class="btn btn-secondary mt-3">Tambah Obat</button>
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('dokter.konsultasi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>

        <script>
            let deletedObatIds = [];
            let countLayanan = {{ $konsultasi->layanan->count() }};
            let countObat = {{ $konsultasi->resepObat->count() }};
            
           // Mengupdate opsi dropdown obat untuk menghindari duplikasi dan stok habis
        function updateObatDropdowns() {
            const selectedObatIds = Array.from(document.querySelectorAll('select[name^="obat"]'))
                .map(select => select.value); // Ambil ID obat yang sudah dipilih

            // Menonaktifkan opsi obat yang sudah dipilih
            document.querySelectorAll('select[name^="obat"]').forEach(select => {
                Array.from(select.options).forEach(option => {
                    const obatId = option.value;
                    const obat = @json($obat).find(obat => obat.id_obat == obatId); // Temukan data obat berdasarkan ID
                    const stock = obat ? obat.stok : 0; // Dapatkan stok obat

                    if (obatId === "" && option.text.includes("(Stok Habis)")) {
                        option.text = "Pilih Obat"; // Reset teks opsi default
                    }

                    if (stock <= 0) {
                        option.disabled = true;
                        if (option.value !== "") {
                            option.text = option.text.replace("(Stok Habis)", "") + " (Stok Habis)";
                        }
                    } else if (selectedObatIds.includes(obatId) && obatId !== select.value) {
                        option.disabled = true; // Disable jika obat sudah dipilih di dropdown lain
                    } else {
                        option.disabled = false; // Aktifkan kembali opsi jika belum dipilih
                        option.text = option.text.replace(" (Stok Habis)", "");
                    }
                });
            });
        }

        // Hapus resep obat
        function removeObatField(id) {
            const field = document.getElementById(`obat-field-${id}`);
            if (field) {
                field.remove();
                deletedObatIds.push(id); // Simpan ID resep yang dihapus
                document.getElementById('deleted-obat-ids').value = deletedObatIds.join(',');
            }
            updateObatDropdowns(); // Perbarui dropdown obat
        }

        // Tambah resep obat baru
        document.getElementById('add-obat').addEventListener('click', function () {
            const container = document.getElementById('resep-obat-container');
            const newField = `
                <div class="form-group mt-3 d-flex align-items-center" id="obat-field-new-${countObat}">
                    <div class="w-100">
                        <select name="obat[new-${countObat}][id_obat]" class="form-control obat-select" required onchange="updateObatDropdowns()">
                            <option value="" disabled selected>Pilih Obat</option>
                            @foreach ($obat as $item)
                                <option value="{{ $item->id_obat }}" {{ $item->stok <= 0 ? 'disabled' : '' }}>
                                    {{ $item->nama_obat }} 
                                    {{ $item->stok <= 0 ? '(Stok Habis)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="obat[new-${countObat}][jumlah]" class="form-control mt-2" placeholder="Jumlah" required>
                    </div>
                    <button type="button" class="btn btn-danger ml-2" onclick="removeObatField('new-${countObat}')">Hapus</button>
                </div>`;
            container.insertAdjacentHTML('beforeend', newField);
            countObat++;
            updateObatDropdowns();
        });
        
            // Mengupdate opsi dropdown layanan untuk menghindari duplikasi layanan yang sudah dipilih
function updateLayananDropdowns() {
    const selectedLayananIds = Array.from(document.querySelectorAll('select[name^="layanan_id"]'))
        .map(select => select.value); // Ambil ID layanan yang sudah dipilih

    // Menonaktifkan opsi layanan yang sudah dipilih
    document.querySelectorAll('select[name^="layanan_id"]').forEach(select => {
        Array.from(select.options).forEach(option => {
            if (selectedLayananIds.includes(option.value) && option.value !== select.value) {
                option.disabled = true; // Menonaktifkan opsi yang sudah dipilih
            } else {
                option.disabled = false; // Mengaktifkan opsi jika belum dipilih
            }
        });
    });
}

// Hapus layanan
function removeLayananField(id) {
    const field = document.getElementById(`layanan-field-${id}`);
    if (field) {
        field.remove();
    }
    updateLayananDropdowns(); // Perbarui dropdown layanan
}

// Tambah layanan baru
document.getElementById('add-layanan').addEventListener('click', function () {
    const container = document.getElementById('layanan-container');
    const newField = `
        <div class="form-group mt-3 d-flex align-items-center" id="layanan-field-new-${countLayanan}">
            <div class="w-100">
                <select name="layanan_id[new-${countLayanan}]" class="form-control" required onchange="updateLayananDropdowns()">
                    <option value="" disabled selected>Pilih Layanan</option>
                    @foreach ($layanan as $item)
                        <option value="{{ $item->id_layanan }}">{{ $item->nama_layanan }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn btn-danger ml-2" onclick="removeLayananField('new-${countLayanan}')">Hapus</button>
        </div>`;
    container.insertAdjacentHTML('beforeend', newField);
    countLayanan++;
    updateLayananDropdowns(); // Perbarui dropdown setelah menambahkan layanan baru
});
        
            // Inisialisasi
            document.addEventListener('DOMContentLoaded', function () {
                updateLayananDropdowns();
                updateObatDropdowns();
            });
        </script>
        
@endsection