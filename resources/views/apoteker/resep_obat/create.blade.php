@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Resep Obat</h1>

    <form method="POST" action="{{ route('apoteker.resep_obat.store') }}">
        @csrf

        <!-- Konsultasi -->
        <div class="mb-3">
            <label for="id_konsultasi" class="form-label">Konsultasi</label>
            <select name="id_konsultasi" id="id_konsultasi" class="form-control" required>
                @foreach($konsultasi as $k)
                    <option value="{{ $k->id_konsultasi }}">{{ $k->keluhan }}</option>
                @endforeach
            </select>
        </div>

        <!-- Obat -->
        <div id="obat-container">
            <div class="obat-row mb-3">
                <label for="id_obat" class="form-label">Obat</label>
                <select name="obat[0][id_obat]" class="form-control" required>
                    @foreach($obat as $o)
                        <option value="{{ $o->id_obat }}">{{ $o->nama_obat }}</option>
                    @endforeach
                </select>
                <input type="number" name="obat[0][jumlah]" class="form-control mt-2" placeholder="Jumlah" required>
            </div>
        </div>
        <button type="button" id="add-obat" class="btn btn-secondary mb-3">Tambah Obat</button>

        <!-- Keterangan -->
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    let obatIndex = 1;

    document.getElementById('add-obat').addEventListener('click', function() {
        const container = document.getElementById('obat-container');
        const newRow = document.createElement('div');
        newRow.classList.add('obat-row', 'mb-3');
        newRow.innerHTML = `
            <label for="id_obat" class="form-label">Obat</label>
            <select name="obat[${obatIndex}][id_obat]" class="form-control" required>
                @foreach($obat as $o)
                    <option value="{{ $o->id_obat }}">{{ $o->nama_obat }}</option>
                @endforeach
            </select>
            <input type="number" name="obat[${obatIndex}][jumlah]" class="form-control mt-2" placeholder="Jumlah" required>
        `;
        container.appendChild(newRow);
        obatIndex++;
    });
</script>
@endsection
