@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-4"><i class="fas fa-pills"></i> Edit Obat</h2>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">
        <form action="{{ route('apoteker.obat.update', $obat->id_obat) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_obat" class="form-label"><i class="fas fa-capsules text-primary"></i> Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" class="form-control" placeholder="Masukkan nama obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_obat" class="form-label"><i class="fas fa-tag text-success"></i> Jenis Obat</label>
                <input type="text" name="jenis_obat" id="jenis_obat" class="form-control" placeholder="Masukkan jenis obat" value="{{ old('jenis_obat', $obat->jenis_obat) }}">
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label"><i class="fas fa-boxes text-warning"></i> Stok</label>
                <input type="number" name="stok" id="stok" class="form-control" placeholder="Masukkan stok" value="{{ old('stok', $obat->stok) }}" min="1" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label"><i class="fas fa-money-bill-wave text-danger"></i> Harga (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="harga" id="harga" class="form-control" placeholder="Masukkan harga" value="{{ old('harga', $obat->harga) }}" required>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('apoteker.obat.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Format Harga Otomatis -->
<script>
    document.getElementById('harga').addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '');
        this.value = new Intl.NumberFormat('id-ID').format(value);
    });
</script>

@endsection