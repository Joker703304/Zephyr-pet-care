@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Resep Obat</h1>

    <form action="{{ route('apoteker.resep_obat.update', $id_konsultasi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_konsultasi" class="form-label">Konsultasi</label>
            <select name="id_konsultasi" id="id_konsultasi" class="form-control @error('id_konsultasi') is-invalid @enderror" disabled>
                <option value="{{ $id_konsultasi }}">
                    {{ $resepGroup->first()->konsultasi->keluhan }}
                </option>
            </select>
            <input type="hidden" name="id_konsultasi" value="{{ $id_konsultasi }}">
        </div>

        <div id="obat-container">
            @foreach ($resepGroup as $index => $resep)
            <div class="row mb-3 obat-row">
                <div class="col-md-6">
                    <label for="id_obat_{{ $index }}" class="form-label">Obat</label>
                    <select name="id_obat[]" id="id_obat_{{ $index }}" class="form-control @error('id_obat.' . $index) is-invalid @enderror">
                        <option value="">Pilih Obat</option>
                        @foreach ($obat as $item)
                            <option value="{{ $item->id_obat }}" {{ $resep->id_obat == $item->id_obat ? 'selected' : '' }}>{{ $item->nama_obat }} ({{ $item->jenis_obat }})</option>
                        @endforeach
                    </select>
                    @error('id_obat.' . $index)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="jumlah_{{ $index }}" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah[]" id="jumlah_{{ $index }}" class="form-control @error('jumlah.' . $index) is-invalid @enderror" value="{{ $resep->jumlah }}">
                    @error('jumlah.' . $index)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="hapus_{{ $index }}" class="form-label d-block">Aksi</label>
                    <button type="button" class="btn btn-danger remove-obat">Hapus</button>
                </div>
            </div>
            @endforeach
        </div>

        <button type="button" id="add-obat" class="btn btn-success mb-3">Tambah Obat</button>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ $resepGroup->first()->keterangan }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Dropdown Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="sedang disiapkan" {{ $resepGroup->first()->status == 'sedang disiapkan' ? 'selected' : '' }}>Sedang Disiapkan</option>
                <option value="siap" {{ $resepGroup->first()->status == 'siap' ? 'selected' : '' }}>Siap</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Resep Obat</button>
        <a href="{{ route('apoteker.resep_obat.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const obatContainer = document.getElementById('obat-container');
        const addObatButton = document.getElementById('add-obat');

        addObatButton.addEventListener('click', function () {
            const newIndex = obatContainer.children.length;
            const newRow = document.createElement('div');
            newRow.className = 'row mb-3 obat-row';
            newRow.innerHTML = `
                <div class="col-md-6">
                    <label for="id_obat_${newIndex}" class="form-label">Obat</label>
                    <select name="id_obat[]" id="id_obat_${newIndex}" class="form-control">
                        <option value="">Pilih Obat</option>
                        @foreach ($obat as $item)
                            <option value="{{ $item->id_obat }}">{{ $item->nama_obat }} ({{ $item->jenis_obat }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="jumlah_${newIndex}" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah[]" id="jumlah_${newIndex}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label d-block">Aksi</label>
                    <button type="button" class="btn btn-danger remove-obat">Hapus</button>
                </div>
            `;
            obatContainer.appendChild(newRow);

            // Tambahkan event listener untuk tombol hapus
            newRow.querySelector('.remove-obat').addEventListener('click', function () {
                newRow.remove();
            });
        });

        // Event listener untuk tombol hapus pada baris yang ada
        document.querySelectorAll('.remove-obat').forEach(button => {
            button.addEventListener('click', function () {
                button.closest('.obat-row').remove();
            });
        });
    });
</script>
@endsection