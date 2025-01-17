@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Hewan</h1>

    <form action="{{ route('pemilik-hewan.hewan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Hidden field for id_pemilik -->
        <input type="hidden" name="id_pemilik" value="{{ $pemilikId }}">

        <div class="form-group">
            <label for="nama_hewan">Nama Hewan</label>
            <input type="text" name="nama_hewan" id="nama_hewan" class="form-control" value="{{ old('nama_hewan') }}" required>
        </div>

        <div class="form-group">
            <label for="jenis">Jenis Hewan</label>
            <input type="text" name="jenis" id="jenis" class="form-control" value="{{ old('jenis') }}" required>
        </div>

        <div class="form-group">
            <label for="jenkel">Jenis Kelamin</label>
            <select name="jenkel" id="jenkel" class="form-control" required>
                <option value="jantan" {{ old('jenkel') == 'jantan' ? 'selected' : '' }}>Jantan</option>
                <option value="betina" {{ old('jenkel') == 'betina' ? 'selected' : '' }}>Betina</option>
            </select>
        </div>

        <div class="form-group">
            <label for="umur">Umur (Bulan)</label>
            <input type="number" name="umur" id="umur" class="form-control" value="{{ old('umur') }}">
        </div>

        <div class="form-group">
            <label for="berat">Berat (Gram)</label>
            <input type="number" step="0.01" name="berat" id="berat" class="form-control" value="{{ old('berat') }}">
        </div>

        <div class="form-group">
            <label for="foto">Foto Hewan</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="{{ route('pemilik-hewan.hewan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection
