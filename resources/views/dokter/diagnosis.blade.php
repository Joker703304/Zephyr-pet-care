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
                                    {{ $item->nama_layanan }} ({{ $item->harga }})
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
    let countLayanan = {{ $konsultasi->layanan->count() }};
    let countObat = {{ $konsultasi->resepObat->count() }};

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
    document.getElementById('add-obat').addEventListener('click', function() {
        const container = document.getElementById('resep-obat-container');
        const newField = `
            <div class="form-group mt-3 d-flex align-items-center" id="obat-field-new-${countObat}">
                <div class="w-100">
                    <select name="obat[new-${countObat}][id_obat]" class="form-control" required>
                        @foreach ($obat as $item)
                            <option value="{{ $item->id_obat }}">{{ $item->nama_obat }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="obat[new-${countObat}][jumlah]" class="form-control mt-2" placeholder="Jumlah" required>
                </div>
                <div class="w-100 ml-2">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" name="obat[new-${countObat}][keterangan]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger ml-2" onclick="removeObatField('new-${countObat}')">Hapus</button>
            </div>`;
        container.insertAdjacentHTML('beforeend', newField);
        countObat++;
    });

    // Hapus layanan
    function removeLayananField(id) {
        const field = document.getElementById(`layanan-field-${id}`);
        if (field) {
            field.remove();
        }
    }

    // Tambah layanan baru
    document.getElementById('add-layanan').addEventListener('click', function() {
        const container = document.getElementById('layanan-container');
        const newField = `
            <div class="form-group mt-3 d-flex align-items-center" id="layanan-field-new-${countLayanan}">
                <div class="w-100">
                    <select name="layanan_id[new-${countLayanan}]" class="form-control" required>
                        @foreach ($layanan as $item)
                            <option value="{{ $item->id_layanan }}">{{ $item->nama_layanan }} ({{ $item->harga }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-danger ml-2" onclick="removeLayananField('new-${countLayanan}')">Hapus</button>
            </div>`;
        container.insertAdjacentHTML('beforeend', newField);
        countLayanan++;
    });
</script>
@endsection
