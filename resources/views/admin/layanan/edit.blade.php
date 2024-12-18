@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Edit Layanan</h1>
        <form action="{{ route('admin.layanan.update', $layanan->id_layanan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_layanan">Nama Layanan</label>
                <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="{{ $layanan->nama_layanan }}" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi">{{ $layanan->deskripsi }}</textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" step="0.01" value="{{ $layanan->harga }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
