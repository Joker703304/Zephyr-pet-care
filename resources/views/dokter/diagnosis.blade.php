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
        <div class="form-group">
            <label for="layanan_id">Layanan</label>
            <select name="layanan_id" class="form-control" required>
                <option value="" selected disabled>Pilih Layanan</option>
                @foreach ($layanan as $item)
                    <option value="{{ $item->id_layanan }}" {{ $konsultasi->layanan_id == $item->id_layanan ? 'selected' : '' }}>
                        {{ $item->nama_layanan }} ({{ $item->harga }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Resep Obat --}}
        <h5>Resep Obat</h5>
        <div id="resep-obat-container">
            @foreach ($konsultasi->resepObat as $index => $resep)
                <div class="form-group mt-3 d-flex align-items-center" id="obat-field-{{ $resep->id_resep }}">
                    <div class="w-100">
                        <select name="obat[{{ $resep->id_resep }}][id_obat]" class="form-control obat-select" required>
                            @foreach ($obat as $item)
                                <option value="{{ $item->id_obat }}" {{ $resep->id_obat == $item->id_obat ? 'selected' : '' }}>
                                    {{ $item->nama_obat }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="obat[{{ $resep->id_resep }}][jumlah]" class="form-control mt-2" value="{{ $resep->jumlah }}" required>
                    </div>
                    <div class="w-100 ml-2">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="obat[{{ $resep->id_resep }}][keterangan]" class="form-control" value="{{ old('obat.'.$resep->id_resep.'.keterangan', $resep->keterangan) }}">
                    </div>
                    <button type="button" class="btn btn-danger ml-2" onclick="removeObatField('{{ $resep->id_resep }}')">Hapus</button>
                </div>
            @endforeach
        </div>
        <input type="hidden" name="deleted_obat_ids" id="deleted-obat-ids" value="">

        <button type="button" id="add-obat" class="btn btn-secondary mt-3">Tambah Obat</button>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>

<script>
    let deletedObatIds = [];

    // Hapus resep obat
    function removeObatField(id) {
        const field = document.getElementById(`obat-field-${id}`);
        if (field) {
            field.remove();
            deletedObatIds.push(id); // Simpan ID resep yang dihapus
            document.getElementById('deleted-obat-ids').value = deletedObatIds.join(',');
        }
    }

    // Tambah resep obat baru
    let count = {{ $konsultasi->resepObat->count() }};
    document.getElementById('add-obat').addEventListener('click', function() {
        const container = document.getElementById('resep-obat-container');
        const newField = `
            <div class="form-group mt-3 d-flex align-items-center" id="obat-field-new-${count}">
                <div class="w-100">
                    <select name="obat[new-${count}][id_obat]" class="form-control" required>
                        @foreach ($obat as $item)
                            <option value="{{ $item->id_obat }}">{{ $item->nama_obat }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="obat[new-${count}][jumlah]" class="form-control mt-2" placeholder="Jumlah" required>
                </div>
                <div class="w-100 ml-2">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="obat[new-${count}][keterangan]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger ml-2" onclick="removeObatField('new-${count}')">Hapus</button>
            </div>`;
        container.insertAdjacentHTML('beforeend', newField);
        count++;
    });
</script>
@endsection
